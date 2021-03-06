<?php

/*
 * This file is part of the NelmioApiDocBundle.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nelmio\ApiDocBundle\Extractor\Handler;

use Nelmio\ApiDocBundle\Extractor\HandlerInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Annotation\Route as BasicRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as ExtraRoute;


class SensioFrameworkExtraHandler implements HandlerInterface
{
    public function handle(ApiDoc $annotation, array $annotations, Route $route, \ReflectionMethod $method)
    {
        foreach ($annotations as $annot) {
            if ($annot instanceof Cache) {
                $annotation->setCache($annot->getMaxAge());
            } elseif ($annot instanceof Security) {
                $annotation->setAuthentication(true);
            } elseif (($annot instanceof BasicRoute || $annot instanceof ExtraRoute) && $route->getPath() === $annot->getPath()) { 
                $annotation->setRouteName($annot->getName());
            }
        }
    }
}
