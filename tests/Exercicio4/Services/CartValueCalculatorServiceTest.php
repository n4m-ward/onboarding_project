<?php

namespace tests\Exercicio4\Services;

use Onboarding\Exercicio4\Dto\CartDto;
use Onboarding\Exercicio4\Dto\ProductDto;
use Onboarding\Exercicio4\Dto\ProdutoQuantityDto;
use Onboarding\Exercicio4\Dto\UserDto;
use Onboarding\Exercicio4\Integrators\ShippingCalculator;
use Onboarding\Exercicio4\Repositories\UserRepository;
use Onboarding\Exercicio4\Services\CartValueCalculatorService;
use PHPUnit\Framework\TestCase;

class CartValueCalculatorServiceTest extends TestCase
{
    private CartValueCalculatorService $cartCalculatorService;
    private ShippingCalculator $shippingCalculatorMock;
    private UserRepository $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->shippingCalculatorMock = $this->createMock(ShippingCalculator::class);
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->cartCalculatorService = new CartValueCalculatorService(
            $this->shippingCalculatorMock,
            $this->userRepositoryMock
        );
        $fakeUser = new UserDto();
        $fakeUser->attachValues([
            'id' => 5,
            'name' => 'foo',
            'cep' => '1831278'
        ]);
        $this->userRepositoryMock
            ->method('getUserById')
            ->willReturn($fakeUser);
    }

    public function test_calculateCartValue_BringsValueZeroIfCartIsEmpty(): void
    {
        $fakeUser = new UserDto();
        $fakeUser->attachValues([
            'id' => 5,
            'name' => 'foo',
            'cep' => '1831278'
        ]);
        $this->userRepositoryMock
            ->method('getUserById')
            ->willReturn($fakeUser);
        $expectedResult = 0;
        $emptyCart = new CartDto();
        $emptyCart->attachValues(['wishList' => [], 'userId' => 5]);
        $result = $this->cartCalculatorService->calculateCartValue($emptyCart);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_calculateCartValue_BringsValueOfProductIfHaveOneProduct(): void
    {
        $expectedResult = 200;
        $produtoDto = new ProductDto();
        $produtoDto->attachValues([
            'name' => 'foo',
            'price' => $expectedResult,
        ]);
        $produtoQuantityDto = new ProdutoQuantityDto();
        $produtoQuantityDto->attachValues(['product' => $produtoDto]);
        $cart = new CartDto();
        $cart->attachValues(['wishList' => [$produtoQuantityDto], 'userId' => 5]);
        $result = $this->cartCalculatorService->calculateCartValue($cart);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_calculateCartValue_BringsDoubleValueIfProductQuantityPassedIsTwo(): void
    {
        $productQuantity = 2;
        $productValue = 25;
        $expectedResult = $productValue * $productQuantity;
        $produtoDto = new ProductDto();
        $produtoDto->attachValues([
            'name' => 'foo',
            'price' => $productValue,
        ]);
        $produtoQuantityDto = new ProdutoQuantityDto();
        $produtoQuantityDto->attachValues(['product' => $produtoDto, 'quantity' => $productQuantity]);
        $cart = new CartDto();
        $cart->attachValues(['wishList' => [$produtoQuantityDto], 'userId' => 5]);
        $result = $this->cartCalculatorService->calculateCartValue($cart);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_calculateCartValue_BringsFreightValueIfProductValueIsLessThan100(): void
    {
        $freightValue = 23.00;
        $productValue = 25;
        $expectedResult = $productValue + $freightValue;
        $this->shippingCalculatorMock
            ->method('calculateShipppingByCep')
            ->willReturn($freightValue);
        $produtoDto = new ProductDto();
        $produtoDto->attachValues([
            'name' => 'foo',
            'price' => $productValue,
        ]);
        $produtoQuantityDto = new ProdutoQuantityDto();
        $produtoQuantityDto->attachValues(['product' => $produtoDto]);
        $cart = new CartDto();
        $cart->attachValues(['wishList' => [$produtoQuantityDto], 'userId' => 5]);
        $result = $this->cartCalculatorService->calculateCartValue($cart);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_calculateCartValue_DoesNotBringsFreightValueIfProductValueIsGreaterThan100(): void
    {
        $freightValue = 23.00;
        $productValue = 200;
        $expectedResult = $productValue;
        $this->shippingCalculatorMock
            ->method('calculateShipppingByCep')
            ->willReturn($freightValue);
        $produtoDto = new ProductDto();
        $produtoDto->attachValues([
            'name' => 'foo',
            'price' => $productValue,
        ]);
        $produtoQuantityDto = new ProdutoQuantityDto();
        $produtoQuantityDto->attachValues(['product' => $produtoDto]);
        $cart = new CartDto();
        $cart->attachValues(['wishList' => [$produtoQuantityDto], 'userId' => 5]);
        $result = $this->cartCalculatorService->calculateCartValue($cart);

        $this->assertEquals($expectedResult, $result);
    }
}