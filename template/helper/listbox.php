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
        $config->append(array(
            'autocomplete' => true,
            'autocreate'   => true,
            'component'    => $this->getIdentifier()->package,
            'entity'   => null,
            'name'     => 'tags',
            'value'    => 'title',
            'prompt'   => false,
            'deselect' => false,
            'attribs'  => array(
                'multiple' => true
            ),
        ))->append(array(
            'model'  => $this->getObject('com:tags.model.tags', array('table' => $config->component.'_tags')),
            'options' => array(
                'tokenSeparators' => array(',', ' '),
                'tags'            => $config->autocreate
            ),
        ));

        //Set the selected tags
        if ($config->entity instanceof KModelEntityInterface && $config->entity->isTaggable())
        {
            $config->append(array(
                'selected' => $config->entity->getTags(),
            ));
        }

        //Set the autocompplete url
        if ($config->autocomplete)
        {
            $parts = array(
                'component' => $config->component,
                'view'      => 'tags',
            );

            if ($config->filter) {
                $parts = array_merge($parts, KObjectConfig::unbox($config->filter));
            }

            $config->url = $this->getTemplate()->route($parts, false, false);
        }

        //Do not allow to override label and sort
        $config->label = 'title';
        $config->sort  = 'title';

        return parent::_render($config);
    }
}
