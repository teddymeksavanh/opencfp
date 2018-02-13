<?php

declare(strict_types=1);

/**
 * Copyright (c) 2013-2018 OpenCFP.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/opencfp/opencfp
 */

namespace OpenCFP\Test\Unit\Http\Action\Security;

use Localheinz\Test\Util\Helper;
use OpenCFP\Domain\Services;
use OpenCFP\Http\Action\Security\LogInAction;
use PHPUnit\Framework;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation;
use Symfony\Component\Routing;
use Twig_Environment;

final class LogInActionTest extends Framework\TestCase
{
    use Helper;

    public function testRendersLogInFormIfAuthenticationFailed()
    {
        $faker = $this->faker();

        $email = $faker->email;
        $password = $faker->password;

        $content = $faker->text;

        $exceptionMessage = $faker->sentence;

        $session = $this->prophesize(HttpFoundation\Session\SessionInterface::class);

        $session
            ->set(
                Argument::exact('flash'),
                Argument::exact([
                    'type' => 'error',
                    'short' => 'Error',
                    'ext' => $exceptionMessage,
                ])
            )
            ->shouldBeCalled();

        $request = $this->prophesize(HttpFoundation\Request::class);

        $request
            ->get(Argument::exact('email'))
            ->shouldBeCalled()
            ->willReturn($email);

        $request
            ->get(Argument::exact('password'))
            ->shouldBeCalled()
            ->willReturn($password);

        $request->getSession()
            ->shouldBeCalled()
            ->willReturn($session);

        $authentication = $this->prophesize(Services\Authentication::class);

        $authentication
            ->authenticate(
                Argument::exact($email),
                Argument::exact($password)
            )
            ->shouldBeCalled()
            ->willThrow(new Services\AuthenticationException($exceptionMessage));

        $twig = $this->prophesize(Twig_Environment::class);

        $twig
            ->render(
                Argument::exact('security/login.twig'),
                Argument::exact([
                    'email' => $email,
                    'flash' => [
                        'type' => 'error',
                        'short' => 'Error',
                        'ext' => $exceptionMessage,
                    ],
                ])
            )
            ->shouldBeCalled()
            ->willReturn($content);

        $action = new LogInAction(
            $authentication->reveal(),
            $twig->reveal(),
            $this->prophesize(Routing\Generator\UrlGeneratorInterface::class)->reveal()
        );

        $response = $action($request->reveal());

        $this->assertInstanceOf(HttpFoundation\Response::class, $response);
        $this->assertSame(HttpFoundation\Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertSame($content, $response->getContent());
    }

    public function testRedirectsToDashboardIfAuthenticationSucceeded()
    {
        $faker = $this->faker();

        $email = $faker->email;
        $password = $faker->password;

        $url = $faker->url;

        $request = $this->prophesize(HttpFoundation\Request::class);

        $request
            ->get(Argument::exact('email'))
            ->shouldBeCalled()
            ->willReturn($email);

        $request
            ->get(Argument::exact('password'))
            ->shouldBeCalled()
            ->willReturn($password);

        $authentication = $this->prophesize(Services\Authentication::class);

        $authentication
            ->authenticate(
                Argument::exact($email),
                Argument::exact($password)
            )
            ->shouldBeCalled();

        $urlGenerator = $this->prophesize(Routing\Generator\UrlGeneratorInterface::class);

        $urlGenerator
            ->generate('dashboard')
            ->shouldBeCalled()
            ->willReturn($url);

        $action = new LogInAction(
            $authentication->reveal(),
            $this->prophesize(Twig_Environment::class)->reveal(),
            $urlGenerator->reveal()
        );

        /** @var HttpFoundation\RedirectResponse $response */
        $response = $action($request->reveal());

        $this->assertInstanceOf(HttpFoundation\RedirectResponse::class, $response);
        $this->assertSame(HttpFoundation\Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertSame($url, $response->getTargetUrl());
    }
}
