<?php

namespace tests\Exercicio4\Services;

use Exception;
use Onboarding\Exercicio4\Database\CartDb;
use Onboarding\Exercicio4\Database\ProductDb;
use Onboarding\Exercicio4\Database\UserDb;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;
use Onboarding\Exercicio4\Integrators\ShippingCalculator;
use Onboarding\Exercicio4\Repositories\CartRepository;
use Onboarding\Exercicio4\Repositories\UserRepository;
use Onboarding\Exercicio4\Services\CartService;
use Onboarding\Exercicio4\Services\CartValueCalculatorService;
use PHPUnit\Framework\TestCase;
use tests\Exercicio4\TestUtils\DbTransaction;

class CartServiceTest extends TestCase
{
    private UserDb $userDb;
    private CartDb $cartDb;
    private ProductDb $productDb;
    private CartService $cartService;
    private ShippingCalculator $shippingCalculator;

    public function setUp(): void
    {
        parent::setUp();
        $cartRepository = new CartRepository();
        $this->shippingCalculator = $this->createMock(ShippingCalculator::class);
        $userRepository = new UserRepository();
        $this->userDb = new UserDb();
        $this->cartDb = new CartDb();
        $this->productDb = new ProductDb();
        $cartCalculatorService = new CartValueCalculatorService(
            shippingCalculator: $this->shippingCalculator,
            userRepository: $userRepository
        );
        $this->cartService = new CartService(
            cartRepository: $cartRepository,
            calculatorService: $cartCalculatorService
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        DbTransaction::rollback();
    }

    /**
     * @throws Exception
     */
    public function test_addItemToCart_saveItem(): void
    {
        $user = $this->userDb->factory();
        $product = $this->productDb->factory();
        $productArray = [
            $product,
        ];
        $this->cartService
            ->addItemToCart(
                userId: $user->id,
                products: $productArray
            );
        $cart = $this->cartService->getCartByUserId($user->id);
        $cartFirstProduct = $cart->cart->wishList[0]->product;

        $this->assertEquals($product->name, $cartFirstProduct->name);
        $this->assertEquals($product->price, $cartFirstProduct->price);
    }

    public function test_addItemToCart_increaseItemQuantity_whenProductAlreadyExist(): void
    {
        $carrinho = $this->cartDb->factory();
        $cartProductQuantityDto = $carrinho->wishList[0];
        $expectedProductQuantity = $cartProductQuantityDto->quantity + 2;
        $productArray = [
            $cartProductQuantityDto->product,
            $cartProductQuantityDto->product,
        ];
        $this->cartService
            ->addItemToCart(
                userId: $carrinho->userId,
                products: $productArray
            );
        $cartAfterUpdate = $this->cartService->getCartByUserId($carrinho->userId);
        $finalProductQuantity = $cartAfterUpdate
            ->cart
            ->wishList[0]
            ->quantity;

        $this->assertCount(1, $cartAfterUpdate->cart->wishList);
        $this->assertEquals($expectedProductQuantity, $finalProductQuantity);
    }

    public function test_addItemToCart_increaseItemQuantity_whenProductNotExist(): void
    {
        $carrinho = $this->cartDb->factory(params: ['wishList' => []]);
        $productArray = $this->productDb->factory(
            quantity: 2,
            params: ['name' => 'foo', 'price' => 25.00]
        )->toArray();
        $expectedProductQuantity = 2;
        $this->cartService
            ->addItemToCart(
                userId: $carrinho->userId,
                products: $productArray
            );
        $cartAfterUpdate = $this->cartService->getCartByUserId($carrinho->userId);
        $finalProduct = collect(
            $cartAfterUpdate
                ->cart
                ->wishList
        )->first();

        $this->assertCount(1, $cartAfterUpdate->cart->wishList);
        $this->assertEquals($expectedProductQuantity, $finalProduct->quantity);
    }

    /**
     * @throws Exception
     */
    public function test_GetCartByUserId_Works(): void
    {
        $mockCart = $this->cartDb->factory();
        $cart = $this->cartService->getCartByUserId($mockCart->userId);
        $mockCartItem = $mockCart->wishList[0];
        $cartItem = $cart->cart->wishList[0];

        $this->assertEquals(
            count($mockCart->wishList),
            count($cart->cart->wishList)
        );
        $this->assertEquals($mockCartItem->product->name, $cartItem->product->name);
        $this->assertEquals($mockCartItem->product->price, $cartItem->product->price);
    }

    /**
     * @throws Exception
     */
    public function test_GetCartByUserId_BringsZeroValue_IfCartIsEmpty(): void
    {
        $expectedResult = 0.0;
        $mockCart = $this->cartDb->factory(params: ['wishList' => []]);
        $cart = $this->cartService->getCartByUserId($mockCart->userId);

        $this->assertEquals($cart->totalValue, $expectedResult);
    }

    /**
     * @throws Exception
     */
    public function test_GetCartByUserId_BringsShippingValue_IfValueIsLessThan100(): void
    {
        $freightValue = 20.00;
        $productValue = 50.00;

        $expectedResult = $productValue + $freightValue;
        /* @phpstan-ignore-next-line */
        $this->shippingCalculator->method('calculateShipppingByCep')
            ->willReturn($freightValue);
        $product = $this->productDb->factory(params: ['price' => $productValue]);
        $produtoQuantity = (new ProdutoQuantityDto())
            ->attachValues([
                'product' => $product,
            ]);
        $mockCart = $this->cartDb->factory(params: ['wishList' => [$produtoQuantity]]);
        $cart = $this->cartService->getCartByUserId($mockCart->userId);

        $this->assertEquals($expectedResult, $cart->totalValue);
    }

    /**
     * @throws Exception
     */
    public function test_removeCartItem_Works(): void
    {
        $productQuantity = 5;
        $productQuantityToRemove = 2;
        $expectedProductQuantity = $productQuantity - $productQuantityToRemove;
        $product = (new ProductDb())->factory();
        $productQuantityDto = (new ProdutoQuantityDto())
            ->attachValues([
                'product' => $product,
                'quantity' => $productQuantity
            ]);
        $cart = (new CartDb())->factory(params: ['wishList' => [$productQuantityDto]]);
        $this->cartService->removeCartItemByUserId(
            userId: $cart->userId,
            productId: $product->id,
            quantity: $productQuantityToRemove
        );
        $cartAfterUpdate = $this->cartService->getCartByUserId($cart->userId);
        $finalProductQuantity = $cartAfterUpdate->cart->wishList[0]->quantity;

        $this->assertEquals($expectedProductQuantity, $finalProductQuantity);
    }

    public function test_removeCartItem_removeProduct_ifQuantityToRemoveIsGreaterThanProductQuantity(): void
    {
        $productQuantity = 5;
        $productQuantityToRemove = 6;
        $product = $this->productDb->factory();
        $productQuantityDto = (new ProdutoQuantityDto())
            ->attachValues([
                'product' => $product,
                'quantity' => $productQuantity
            ]);
        $cart = $this->cartDb->factory(params: ['wishList' => [$productQuantityDto]]);
        $this->cartService->removeCartItemByUserId(
            userId: $cart->userId,
            productId: $product->id,
            quantity: $productQuantityToRemove
        );
        $cartAfterUpdate = $this->cartService->getCartByUserId($cart->userId);
        $finalProductQuantity = $cartAfterUpdate->cart->wishList;

        $this->assertEmpty($finalProductQuantity);
    }

    public function test_clearCartProductsByUserId_work(): void
    {
        $expectedCartTotalValue = 0.0;
        $cart = $this->cartDb->factory();
        $this->assertNotEmpty($cart->wishList);
        $this->cartService->clearCartProductsByUserId($cart->userId);
        $cartAfterUpdate = $this->cartService->getCartByUserId($cart->userId);

        $this->assertEmpty($cartAfterUpdate->cart->wishList);
        $this->assertEquals($expectedCartTotalValue, $cartAfterUpdate->totalValue);
    }
}
