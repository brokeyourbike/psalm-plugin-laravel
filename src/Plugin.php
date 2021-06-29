<?php
namespace BrokeYourBike\LaravelPlugin;

use function glob;
use function dirname;
use SimpleXMLElement;
use Psalm\Plugin\RegistrationInterface;
use Psalm\Plugin\PluginEntryPointInterface;
use BrokeYourBike\LaravelPlugin\Providers\ModelStubProvider;
use BrokeYourBike\LaravelPlugin\Providers\FacadeStubProvider;
use BrokeYourBike\LaravelPlugin\Providers\ApplicationProvider;
use BrokeYourBike\LaravelPlugin\Handlers\Helpers\ViewHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Helpers\UrlHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Helpers\TransHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Helpers\RedirectHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Helpers\PathHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Eloquent\RelationsMethodHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Eloquent\ModelRelationshipPropertyHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Eloquent\ModelPropertyAccessorHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Eloquent\ModelMethodHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Application\OffsetHandler;
use BrokeYourBike\LaravelPlugin\Handlers\Application\ContainerHandler;

class Plugin implements PluginEntryPointInterface
{

    public function __invoke(RegistrationInterface $registration, ?SimpleXMLElement $config = null) : void
    {
        try {
            ApplicationProvider::bootApp();
            $this->generateStubFiles();
        } catch (\Throwable $t) {
            return;
        }

        $this->registerHandlers($registration);
        $this->registerStubs($registration);
    }

    private function registerStubs(RegistrationInterface $registration): void
    {
        foreach (glob(dirname(__DIR__) . '/stubs/*.stubphp') as $stubFilePath) {
            $registration->addStubFile($stubFilePath);
        }

        $registration->addStubFile(FacadeStubProvider::getStubFileLocation());
        $registration->addStubFile(ModelStubProvider::getStubFileLocation());
    }

    /**
     * @param \Psalm\Plugin\RegistrationInterface $registration
     */
    private function registerHandlers(RegistrationInterface $registration): void
    {
        require_once 'Handlers/Application/ContainerHandler.php';
        $registration->registerHooksFromClass(ContainerHandler::class);
        require_once 'Handlers/Application/OffsetHandler.php';
        $registration->registerHooksFromClass(OffsetHandler::class);
        require_once 'Handlers/Eloquent/ModelRelationshipPropertyHandler.php';
        $registration->registerHooksFromClass(ModelRelationshipPropertyHandler::class);
        require_once 'Handlers/Eloquent/ModelPropertyAccessorHandler.php';
        $registration->registerHooksFromClass(ModelPropertyAccessorHandler::class);
        require_once 'Handlers/Eloquent/RelationsMethodHandler.php';
        $registration->registerHooksFromClass(RelationsMethodHandler::class);
        require_once 'Handlers/Eloquent/ModelMethodHandler.php';
        $registration->registerHooksFromClass(ModelMethodHandler::class);
        require_once 'Handlers/Helpers/ViewHandler.php';
        $registration->registerHooksFromClass(ViewHandler::class);
        require_once 'Handlers/Helpers/PathHandler.php';
        $registration->registerHooksFromClass(PathHandler::class);
        require_once 'Handlers/Helpers/UrlHandler.php';
        $registration->registerHooksFromClass(UrlHandler::class);
        require_once 'Handlers/Helpers/TransHandler.php';
        $registration->registerHooksFromClass(TransHandler::class);
        require_once 'Handlers/Helpers/RedirectHandler.php';
        $registration->registerHooksFromClass(RedirectHandler::class);
    }

    private function generateStubFiles(): void
    {
        FacadeStubProvider::generateStubFile();
        ModelStubProvider::generateStubFile();
    }
}
