<?php
/**
 * Tagging Component for Joomlatools Framework - http://developer.joomlatools.com/framework
 *
 * @copyright   Copyright (C) 2016 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://github.com/joomlatools/joomlatools-framework-tags for the canonical source repository
 */


/**
 * Listbox Template Helper
 *
 * @author  Tom Janssens <http://github.com/tomjanssens>
 * @package Koowa\Component\Tags
 */
class ComTagsTemplateHelperListbox extends KTemplateHelperListbox
{
    /**
     * Tags listbox helper
     *
     * @param array $config
     * @return string
     */
    public function tags($config = array())
    {
        $config = new KObjectConfig($config);
        $package = $this->getTemplate()->getIdentifier()->package;

        $config->append(array(
            'identifier' => 'com:'.$package.'.model.tags',
            'package' => $package,
            'entity' => null,
            'name' => 'tags[]',
            'value' => 'slug',
            'label' => 'title',
            'sort' => 'title',
            'prompt' => false,
            'deselect' => false,
            'select2' => true,
            'can_create' => false,
            'autocomplete' => true,
            'attribs' => array(
                'multiple' => true
            ),
            ))->append(array(
            'options' => array(
              'tags' => $config->can_create
            )
        ));

        if ($config->entity){
            $config->append(array(
                'selected' => $config->entity->getTags(),
            ));
        }

        return parent::_render($config);
    }
}
