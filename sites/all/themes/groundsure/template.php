<?php

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function groundsure_preprocess_maintenance_page(&$vars, $hook) {
  // When a variable is manipulated or added in preprocess_html or
  // preprocess_page, that same work is probably needed for the maintenance page
  // as well, so we can just re-use those functions to do that work here.
  // groundsure_preprocess_html($variables, $hook);
  // groundsure_preprocess_page($variables, $hook);

  // This preprocessor will also be used if the db is inactive. To ensure your
  // theme is used, add the following line to your settings.php file:
  // $conf['maintenance_theme'] = 'groundsure';
  // Also, check $vars['db_is_active'] before doing any db queries.
}

/**
 * Implements hook_modernizr_load_alter().
 *
 * @return
 *   An array to be output as yepnope testObjects.
 */
/* -- Delete this line if you want to use this function
function groundsure_modernizr_load_alter(&$load) {

}

/**
 * Implements hook_preprocess_html()
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_html(&$vars) {

}

/**
 * Override or insert variables into the page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function groundsure_preprocess_page(&$vars) {
  unset($vars['page']['content']['system_main']['default_message']);
}

/**
 * Override or insert variables into the region templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_region(&$vars, $hook) {

}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_block(&$vars, $hook) {

}
// */

/**
 * Override or insert variables into the entity template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("entity" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_entity(&$vars, $hook) {

}
// */

/**
 * Override or insert variables into the node template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_node(&$vars, $hook) {
  $node = $vars['node'];
}
// */

/**
 * Override or insert variables into the field template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("field" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_field(&$vars, $hook) {

}
// */

/**
 * Override or insert variables into the comment template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_comment(&$vars, $hook) {
  $comment = $vars['comment'];
}
// */

/**
 * Override or insert variables into the views template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function groundsure_preprocess_views_view(&$vars) {
  $view = $vars['view'];
}
// */


/**
 * Override or insert css on the site.
 *
 * @param $css
 *   An array of all CSS items being requested on the page.
 */
/* -- Delete this line if you want to use this function
function groundsure_css_alter(&$css) {

}
// */

/**
 * Override or insert javascript on the site.
 *
 * @param $js
 *   An array of all JavaScript being presented on the page.
 */
/* -- Delete this line if you want to use this function
function groundsure_js_alter(&$js) {

}
// */

function groundsure_form_user_login_block_alter(&$form, &$form_state, $form_id) {
  // Modification for the form with the given form ID goes here. For example, if
  // FORM_ID is "user_register_form" this code would run only on the user
  // registration form.
  $form['name']['#title'] = '';
  $form['name']['#placeholder'] = 'Username';
  $form['pass']['#title'] = '';
  $form['pass']['#placeholder'] = 'Password';
  $form['links']['#markup'] = '<ul><li class="first">' . l(t('forgot password?'), 'user/password', array('attributes' => array('title' => 'Request new password via e-mail.'))) . '</li></ul>';
}

function groundsure_preprocess_views_view_table(&$vars) {
  $view = $vars['view'];
  $options = $view->style_plugin->options;
  $handler = $view->style_plugin;
  $fields = &$view->field;
  $columns = $handler->sanitize_columns($options['columns'], $fields);
  $active = !empty($handler->active) ? $handler->active : '';
  $order = !empty($handler->order) ? $handler->order : 'asc';
  $query = tablesort_get_query_parameters();
  if (isset($view->exposed_raw_input)) {
    $query += $view->exposed_raw_input;
  }

  foreach ($columns as $field => $column) {
  // render the header labels
    if ($field == $column && empty($fields[$field]->options['exclude'])) {
      $label = filter_xss_admin(!empty($fields[$field]) ? $fields[$field]->label() : ''); // THIS is the only line changed so far.
      if (empty($options['info'][$field]['sortable']) || !$fields[$field]->click_sortable()) {
        $vars['header'][$field] = $label;
      }
      else {
        $initial = !empty($options['info'][$field]['default_sort_order']) ? $options['info'][$field]['default_sort_order'] : 'asc';

        if ($active == $field) {
          $initial = ($order == 'asc') ? 'desc' : 'asc';
        }

        $title = t('sort by @s', array('@s' => $label));
        if ($active == $field) {
          $label .= theme('tablesort_indicator', array('style' => $initial));
        }

        $query['order'] = $field;
        $query['sort'] = $initial;
        $link_options = array(
        'html' => TRUE,
        'attributes' => array('title' => $title),
        'query' => $query,
        );
        $vars['header'][$field] = l($label, $_GET['q'], $link_options);
      }

      // Add a header label wrapper if one was selected.
      if ($vars['header'][$field]) {
        $element_label_type = $fields[$field]->element_label_type(TRUE, TRUE);
        if ($element_label_type) {
          $vars['header'][$field] = '<' . $element_label_type . '>' . $vars['header'][$field] . '</' . $element_label_type . '>';
        }
      }
    }
  }
}
