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
            'filter'   => array(),
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
                'tokenSeparators' => ($config->autocreate) ? array(',', ' ') : array(),
                'tags' => $config->autocreate,
            ),
        ));

        $entity = $config->entity;

        //Set the selected tags
        if ($entity instanceof KModelEntityInterface && $entity->isTaggable() && !$entity->isNew())
        {
            $config->append(array(
                'selected' => $entity->getTags()
            ));
        }

        //Set the autocompplete url
        if ($config->autocomplete)
        {
            $parts = array(
                'component' => $config->component,
                'view'      => 'tags',
                'format'    => 'json'
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
