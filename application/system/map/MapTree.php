<?php

class MapTree {

    // the list that holds the map tree node
    public $tree;

    public function __construct() {
        $this->tree = new MapTreeNode();
    }

    public function add($index_level, $path, $tree = null) {

        // check if tree node is the parent node
        if ($tree == null) {
            // set root node
            $tree = $this->tree;
        }

        // check if current level exsits
        if (!isset($path->getUri()[$index_level])) {

            // add it to most recent node
            $tree->addNodeList($path);

            // end of the line
            return;
        }


        // find key at level
        $url = $path->getUri()[$index_level];
        $key = $url->getUri(true);


        // loop through first row
        foreach($tree->getNodeList() as $node) {

            // check class and
            // check if key matches
            if ((get_class($node) == 'MapTreeNode') && ($node->getKey() == $key)) {

                // found route, go to next level
                $this->add(($index_level+1), $path, $node);

                // found it. break
                return;
            }
        }

        // still not found, need to add key to tree
        // create node
        $node = new MapTreeNode();
        $node->setKey($key);

        // add to tree, go next level
        $tree->addNodeList($node);

        // go to next level
        $this->add(($index_level+1), $path, $node);
    }

    public function search($index_level, $key_list, $tree = null, $callback_loader) {

        $show_log = false;


        // check if tree node is the parent node
        if ($tree == null) {
            // set root node
            $tree = $this->tree;
        }

        // check if current level exsits
        if ((count($key_list)+1) <= $index_level) {
            if ($show_log) {
                echo '--------------------<br />';
            }
            // end of the line
            return false;
        }


        // find key at level
        $key = (isset($key_list[$index_level])) ? $key_list[$index_level] : $key_list[($index_level-1)];

        if ($show_log) {
            echo "$index_level <b>$key</b>" . ' ' .count($key_list) . ' '  . ' ' . '<br />';
        }

        // loop through first row
        foreach($tree->getNodeList() as $node) {

            // check if route is found
            $route_found = false;

            // check class and
            // check if key matches
            if ((get_class($node) == 'MapTreeNode') && ($node->getKey() == $key)) {

                if ($show_log) {
                    echo  '&nbsp;&nbsp;&nbsp;&nbsp;' . $node->getKey() . ' ('.get_class($node).'/'.$key.')<br />';
                }

                // found route, go to next level
                $route_found = $this->search(($index_level+1), $key_list, $node, $callback_loader);

                // if route is found, end of line
                if ($route_found) {
                    return true;
                }
            }

            if ((get_class($node) == 'MapPath') && ($node->getUri()[($index_level-1)]->getUri(true) == $key) && !$route_found) {

                if ($show_log) {
                    echo  '&nbsp;&nbsp;&nbsp;&nbsp;' . $node->getUrl() . ' ('.get_class($node).'/'.$key.')<br />';
                }

                // found route, go to next level
                $node->run(array(), $callback_loader);

                // found it. break
                return true;
            }
        }

        return false;
    }

    public function export() {
        return $this->tree->export();
    }
}
