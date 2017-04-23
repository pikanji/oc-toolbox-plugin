<?php namespace Lovata\Toolbox\Components;

use Lovata\Toolbox\Traits\Helpers\TraitComponentNotFoundResponse;
use Lovata\Toolbox\Models\ExampleModel;
use Cms\Classes\ComponentBase;

/**
 * Class ElementPage
 * @package Lovata\Toolbox\Components
 * @author Andrey Kahranenka, a.khoronenko@lovata.com, LOVATA Group
 */
class ElementPage extends ComponentBase
{
    use TraitComponentNotFoundResponse;

    /** @var ExampleModel */
    protected $obElement;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'lovata.toolbox::lang.component.element_page',
            'description' => 'lovata.toolbox::lang.component.element_page_desc'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        $arProperties = $this->getElementPageProperties();
        return $arProperties;
    }

    /**
     * Get element object
     * @return \Illuminate\Http\Response|null
     */
    public function onRun()
    {
        //Get element slug
        $sElementSlug = $this->property('slug');
        if(empty($sElementSlug)) {
            return $this->getErrorResponse();
        }

        //Get element by slug
        /** @var ExampleModel $obElement */
        $obElement = ExampleModel::getBySlug($sElementSlug)->first();
        if(empty($obElement)) {
            return $this->getErrorResponse();
        }

        $this->obElement = $obElement;
        return null;
    }

    /**
     * Get element data
     * @return array|null
     */
    public function get()
    {
        if(empty($this->obElement)) {
            return null;
        }

        return $this->obElement->getCacheData($this->obElement->id, $this->obElement);
    }
}
