<?php
/**
 * Tagging Component for Joomlatools Framework - http://developer.joomlatools.com/framework
 *
 * @copyright   Copyright (C) 2016 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://github.com/joomlatools/joomlatools-framework-tags for the canonical source repository
 */


/**
 * Tag Model Entity
 *
 * @author  Johan Janssens <http://github.com/johanjanssens>
 * @package Koowa\Component\Tags
 */
class ComTagsModelEntityTags extends KModelEntityRowset
{
    protected function _getCountQuery()
    {
        $ids = array();

        foreach ($this as $entity) {
            $ids[] = $entity->id;
        }

        $table_name = $this->getTable()->getName();

        return $this->getObject('lib:database.query.select')
                ->columns(array('count' => 'COUNT(*)'))
                ->table($taggable)
                ->join(array('tr' => $table_name . '_relations'), 'tr.row = uuid')
                ->join(array('t' => $table_name), 'tr.tag_id = t.tag_id')
                ->where('t.tag_id IN :id')
                ->bind(array('id' => $ids));
    }

    public function setTaggableCount($taggable)
    {
        $map = count($this) ? $this->getCountMap($taggable) : array();

        foreach ($this as $tag) {
            $tag->taggable_count = isset($map[$tag->id]) ? $map[$tag->id]->count : 0;
        }

        return $this;
    }

    public function getCountMap($taggable)
    {
        $table = $this->getTable();
        $query = $this->_getCountQuery($taggable)->columns(array('t.tag_id'))->group('t.tag_id');

        return $table->getAdapter()->select($query, KDatabase::FETCH_OBJECT_LIST, 'tag_id');
    }
}
