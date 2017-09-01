<?php

class MapTreeNode {

    private $key = "";
    private $node_list = array();

    public function setKey($key) {
        $this->key = $key; return $this;
    }

    public function getKey() {
        return $this->key;
    }

    public function getNodeList() {
        return $this->node_list;
    }

    public function addNodeList($item) {
        array_push($this->node_list, $item);
    }

    public function export() {

        $list = array();

        foreach($this->node_list as $node) {
            if (get_class($node) == 'MapTreeNode') {
                $result = $node->export();
                array_push($list, $result);
            } else {
                array_push($list, array(
                    'uri' => $node->getUrl()
                ));
            }
        }

        $export = array(
            "key"       => $this->key,
            "children"  => $list
        );

        return $export;
    }
}
