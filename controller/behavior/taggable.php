<?php
/**
 * Nooku Framework - http://nooku.org/framework
 *
 * @copyright   Copyright (C) 2016 Johan Janssens and Timble CVBA. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://github.com/nooku/nooku-tags for the canonical source repository
 */

/**
 * Taggable Controller Behavior
 *
 * @author  Johan Janssens <http://github.com/johanjanssens>
 * @package Koowa\Component\Tags
 */
class ComTagsControllerBehaviorTaggable extends KBehaviorAbstract
{
    /**
     * Constructor.
     *
     * @param KObjectConfig $config Configuration options.
     */
    public function __construct(KObjectConfig $config)
    {
        parent::__construct($config);

        $this->addCommandCallback('after.add'    , '_setTags');
        $this->addCommandCallback('after.edit'   , '_setTags');
        $this->addCommandCallback('after.delete' , '_removeTags');
    }

    /**
     * Set the tags for an entity
     *
     * @param KControllerContextInterface $context
     * @return bool
     */
    protected function _setTags(KControllerContextInterface $context)
    {
        $entity = $context->result;

        if ($entity->isIdentifiable() && !$context->response->isError())
        {
            $tags   = $entity->getTags();

            $package = $this->getMixer()->getIdentifier()->package;
            if(!$this->getObject('com:'.$package.'.controller.tag')->canAdd()) {
                $status  = KDatabase::STATUS_FETCHED;
            } else {
                $status = null;
            }

            //Delete tags
            if(count($tags))
            {
                $tags->delete();
                $tags->clear();
            }

            //Create tags
            if($entity->tags)
            {
                foreach ($entity->tags as $tag)
                {
                    $properties = array(
                        'title' => $tag,
                        'row'   => $entity->uuid,
                    );

                    $tags->insert($properties, $status);
                }
            }

            $tags->save();
        }
    }

    /**
     * Remove tags from an entity
     *
     * @param KControllerContextInterface $context
     * @return void
     */
    protected function _removeTags(KControllerContextInterface $context)
    {
        $entity = $context->result;
        $status = $entity->getStatus();

        if($entity->isIdentifiable() && $status == $entity::STATUS_DELETED) {
            $entity->getTags()->delete();
        }
    }
}