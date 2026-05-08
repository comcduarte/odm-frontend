<?php

declare(strict_types=1);

namespace Frontend\Page\Controller;

use Dot\Controller\AbstractActionController;
use Dot\DependencyInjection\Attribute\Inject;
use Frontend\Page\Service\PageServiceInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Michelf\Markdown;
use Psr\Http\Message\ResponseInterface;

class PageController extends AbstractActionController
{
    #[Inject(
        PageServiceInterface::class,
        RouterInterface::class,
        TemplateRendererInterface::class,
    )]
    public function __construct(
        protected PageServiceInterface $pageService,
        protected RouterInterface $router,
        protected TemplateRendererInterface $template
    ) {
    }

    public function indexAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('app::home')
        );
    }

    public function homeAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('app::home', ['routeName' => 'home'])
        );
    }

    public function aboutUsAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::about')
        );
    }

    public function premiumContentAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::premium-content')
        );
    }

    public function whoWeAreAction(): ResponseInterface
    {
        return new HtmlResponse(
            $this->template->render('page::who-we-are')
        );
    }
    
    public function termsAction(): ResponseInterface
    {
        $parser = new Markdown();
        $contents = file_get_contents(__DIR__ . '/../../../../TERMS.md');
        $markdown = $parser->defaultTransform($contents);
        
        return new HtmlResponse(
            $this->template->render('page::terms', [
                'markdown' => $markdown,
            ])
        );
    }
    
    public function privacyAction(): ResponseInterface
    {
        $parser = new Markdown();
        $contents = file_get_contents(__DIR__ . '/../../../../PRIVACY.md');
        $markdown = $parser->defaultTransform($contents);
        
        return new HtmlResponse(
            $this->template->render('page::privacy', [
                'markdown' => $markdown,
            ])
        );
    }
}
