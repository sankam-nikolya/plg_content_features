<?php
/**
 * @package     plg_features
 *
 * @copyright   Copyright (C) 2011 - 2016 SNAKAM, Inc. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

class plgContentFeatures extends JPlugin
{

   	public function __construct(& $subject, $config)
    {
        $jinput = JFactory::getApplication()->input;
        $option = $jinput->get('option');
        if ($option <> 'com_content') {
            return true;
        };
        parent::__construct($subject, $config);

        $this->loadLanguage();
    }


    /**
     * Prepare the form to add to the article edit
     *
     * @param object $form
     * @param object $data
     *
     * @return bool
     */
    public function onContentPrepareForm($form, $data)
    {

        if (!($form instanceof JForm))
        {
            $this->_subject->setError('JERROR_NOT_A_FORM');
            return false;
        }

        $name = $form->getName();

        $forms = array(
            'com_content.article' => 'features',
        );

        if (!isset($forms[$name]))
        {
            return true;
        }

        JForm::addFormPath(__DIR__ . '/forms');

        $form->loadFile($forms[$name], false);

        return true;

    }

    /**
     *
     * @param   string   $context  The context of the content being passed to the plugin
     * @param   object   &$article     The article object
     * @param   object   &$params  The article params
     * @param   integer  $page     The 'page' number
     *
     * @return  mixed  html string containing code for the votes if in com_content else boolean false
     *
     * @since   1.6
     */
    public function onContentBeforeDisplay($context, &$article, &$params, $page=0)
    {
        if($context=='com_content.article') {
            if($page > 0) {
                return '';
            }

            $show = (int) $this->params->get('show', 5);

            $attribs = new JRegistry;
            $attribs->loadString($article->attribs);
            $items = $attribs->get('features', $show);

            $feautures = new StdClass;
            $feautures->show = $show;
            $feautures->items = $items;
            $article->feautures = $feautures;

            return;
        }

        return;
    }
}