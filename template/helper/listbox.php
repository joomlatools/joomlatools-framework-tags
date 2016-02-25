<?php
/**
 * Nooku Framework - http://nooku.org/framework
 *
 * @copyright   Copyright (C) 2016 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://github.com/nooku/nooku-tags for the canonical source repository
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
            'package' => $this->getTemplate()->getIdentifier()->package,
            'value'	  => 'title',
            'label'	  => 'title',
            'prompt'   => false,
            'deselect' => false,
        ))->append(array(
            'model'  => $this->getObject('com:tags.model.tags', array('table' => $config->package.'_tags')),
        ));

        $config->label = 'title';
        $config->sort  = 'title';

        return parent::_render($config);
    }
}