<?php
namespace BullSoft\Cart;

class DiscountConditionCompare
{
    /**
     * @var string
     */
    protected $_op;

    /**
     * @var bool
     */
    protected $_isNot;

    /**
     * @var string
     */
    protected $_sourceEntityType;

    //DEV NOTE: use either (left op right) OR (op conditions)
    // but cannot use both operations at the same time
    // examples:
    //         OR conditions means return true if any conditions are true in $_conditions
    //         AND conditions means return true if all conditions are true in $_conditions
    //         left AND right means return true if left and right are both true
    //         left OR right means return true if either left or right are true

    /**
     * @var array
     */
    protected $_conditions;

    /**
     * @var DiscountCondition|DiscountConditionCompare
     */
    protected $_leftCondition;

    /**
     * @var DiscountCondition|DiscountConditionCompare
     */
    protected $_rightCondition;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Enable string casting
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Export object properties as json string
     *
     * @return string JSON
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Export object as array
     *
     * @return array
     */
    public function toArray()
    {
        $leftData = null;
        if (is_object($this->getLeftCondition())) {
            $leftData = $this->getLeftCondition()->toArray();
        }

        $rightData = null;
        if (is_object($this->getRightCondition())) {
            $rightData = $this->getRightCondition()->toArray();
        }

        return array(
            'op'         => $this->getOp(),
            'is_not'     => $this->getIsNot(),
            'left'       => $leftData,
            'right'      => $rightData,
            'conditions' => $this->getConditionsAsArray(),
        );
    }

    /**
     * Import object from json
     *
     * @param string
     * @param bool
     * @return DiscountConditionCompare
     */
    public function importJson($json, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }

        $data = @ (array) json_decode($json, true);
        
        $op = isset($data['op']) ? $data['op'] : '';
        $isNot = (bool) isset($data['is_not']) ? $data['is_not'] : false;

        $left = null;
        $right = null;

        $leftData = isset($data['left']) ? $data['left'] : null;
        $rightData = isset($data['right']) ? $data['right'] : null;
        $conditions = isset($data['conditions']) ? $data['conditions'] : array();

        if (is_array($leftData) || $leftData instanceof stdClass) {
            if (isset($leftData['op']) || isset($leftData->op)) {

                //we have DiscountConditionCompare data
                
                if ($leftData instanceof stdClass) {
                    $left = new DiscountConditionCompare();
                    $left->importStdClass($leftData);
                } else if (is_array($leftData)) {
                    $left = new DiscountConditionCompare();
                    $left->importJson(json_encode($leftData));
                }
                
            } else {

                //we have DiscountCondition data
                
                if ($leftData instanceof stdClass) {
                    $left = new DiscountCondition();
                    $left->importStdClass($leftData);
                } else if (is_array($leftData)) {
                    $left = new DiscountCondition();
                    $left->importJson(json_encode($leftData));
                }

            }
        }

        if (is_array($rightData) || $rightData instanceof stdClass) {
            if (isset($rightData['op']) || isset($rightData->op)) {

                //we have DiscountConditionCompare data
                
                if ($rightData instanceof stdClass) {
                    $right = new DiscountConditionCompare();
                    $right->importStdClass($rightData);
                } else if (is_array($rightData)) {
                    $right = new DiscountConditionCompare();
                    $right->importJson(json_encode($rightData));
                }

            } else {

                //we have DiscountCondition data
                
                if ($rightData instanceof stdClass) {
                    $right = new DiscountCondition();
                    $right->importStdClass($rightData);
                } else if (is_array($rightData)) {
                    $right = new DiscountCondition();
                    $right->importJson(json_encode($rightData));
                }
            }
        }

        if ((is_array($conditions) || $conditions instanceof stdClass) && count($conditions) > 0) {
            foreach($conditions as $data) {
                if (isset($data['op'])) {

                    //we have DiscountConditionCompare data
                    $compare = new DiscountConditionCompare();
                    if ($data instanceof stdClass) {
                        $compare->importStdClass($data);
                        $this->addCondition($compare);
                    } else if (is_array($data)) {
                        $compare->importJson(json_encode($data));
                        $this->addCondition($compare);
                    }
                    
                } else {

                    //we have DiscountCondition data
                    $condition = new DiscountCondition();
                    if ($data instanceof stdClass) {
                        $condition->importStdClass($data);
                        $this->addCondition($condition);
                    } else if (is_array($data)) {
                        $condition->importJson(json_encode($data));
                        $this->addCondition($condition);
                    }
                }
            }
        }

        $this->setOp($op)
             ->setIsNot($isNot)
             ->setLeftCondition($left)
             ->setRightCondition($right)
             ->setConditions($conditions)
             ;

        return $this;
    }

    /**
     * Import object from stdClass
     *
     * @param stdClass
     * @param bool
     * @return DiscountConditionCompare
     */
    public function importStdClass($obj, $reset = true)
    {
        if ($reset) {
            $this->reset();
        }
        
        $op = isset($obj->op) ? $obj->op : '';
        $isNot = (bool) isset($obj->is_not) ? $obj->is_not : false;

        $left = null;
        $right = null;

        $leftData = isset($obj->left) ? $obj->left : null;
        $rightData = isset($obj->right) ? $obj->right : null;

        $conditions = isset($obj->conditions) ? $obj->conditions : array();

        if (is_array($leftData) || $leftData instanceof stdClass) {
            if (isset($leftData['op']) || isset($leftData->op)) {

                //we have DiscountConditionCompare data
                
                if ($leftData instanceof stdClass) {
                    $left = new DiscountConditionCompare();
                    $left->importStdClass($leftData);
                } else if (is_array($leftData)) {
                    $left = new DiscountConditionCompare();
                    $left->importJson(json_encode($leftData));
                }
                
            } else {

                //we have DiscountCondition data
                
                if ($leftData instanceof stdClass) {
                    $left = new DiscountCondition();
                    $left->importStdClass($leftData);
                } else if (is_array($leftData)) {
                    $left = new DiscountCondition();
                    $left->importJson(json_encode($leftData));
                }

            }
        }

        if (is_array($rightData) || $rightData instanceof stdClass) {
            if (isset($rightData['op']) || isset($rightData->op)) {

                //we have DiscountConditionCompare data
                
                if ($rightData instanceof stdClass) {
                    $right = new DiscountConditionCompare();
                    $right->importStdClass($rightData);
                } else if (is_array($rightData)) {
                    $right = new DiscountConditionCompare();
                    $right->importJson(json_encode($rightData));
                }

            } else {

                //we have DiscountCondition data
                
                if ($rightData instanceof stdClass) {
                    $right = new DiscountCondition();
                    $right->importStdClass($rightData);
                } else if (is_array($rightData)) {
                    $right = new DiscountCondition();
                    $right->importJson(json_encode($rightData));
                }
            }
        }

        if ((is_array($conditions) || $conditions instanceof stdClass) && count($conditions) > 0) {
            foreach($conditions as $data) {
                
                if (isset($data->op) || (is_array($data) && isset($data['op']))) {

                    //we have DiscountConditionCompare data
                    $compare = new DiscountConditionCompare();
                    if ($data instanceof stdClass) {
                        $compare->importStdClass($data);
                        $this->addCondition($compare);
                    } else if (is_array($data)) {
                        $compare->importJson(json_encode($data));
                        $this->addCondition($compare);
                    }
                    
                } else {

                    //we have DiscountCondition data
                    $condition = new DiscountCondition();
                    if ($data instanceof stdClass) {
                        $condition->importStdClass($data);
                        $this->addCondition($condition);
                    } else if (is_array($data)) {
                        $condition->importJson(json_encode($data));
                        $this->addCondition($condition);
                    }
                }
            }
        }

        $this->setOp($op)
             ->setIsNot($isNot)
             ->setLeftCondition($left)
             ->setRightCondition($right)
             ->setConditions($conditions)
             ;

        return $this;
    }

    /**
     * Reset this object to html values
     *
     * @return DiscountConditionCompare
     */
    public function reset()
    {
        $this->setOp('')
             ->setIsNot(false)
             ->setLeftCondition(null)
             ->setRightCondition(null)
             ->setConditions(array())
             ;

        return $this;
    }

    /**
     * Get the logic operator eg 'or','and'
     *
     * @return string
     */
    public function getOp()
    {
        return $this->_op;
    }

    /**
     * Set the logic operator eg 'or','and'
     *
     * @param string
     * @return DiscountConditionCompare
     */
    public function setOp($op)
    {
        $this->_op = $op;
        return $this;
    }

    /**
     * Get wheter to return the opposite of the validation result
     *
     * @return bool
     */
    public function getIsNot()
    {
        return $this->_isNot;
    }

    /**
     * Set whether to return the opposite of the validation result
     *
     * @param bool
     * @return DiscountConditionCompare
     */
    public function setIsNot($isNot)
    {
        $this->_isNot = $isNot;
        return $this;
    }

    /**
     * Get the type of the source entity
     *
     * @return string
     */
    public function getSourceEntityType()
    {
        return $this->_sourceEntityType;
    }

    /**
     * Set the type of the source entity
     *
     * @param string
     * @return DiscountConditionCompare
     */
    public function setSourceEntityType($type)
    {
        $this->_sourceEntityType = $type;
        return $this;
    }

    /**
     * Getter for left condition/conditionCompare
     *
     * @return DiscountCondition|DiscountConditionCompare
     */
    public function getLeftCondition()
    {
        return $this->_leftCondition;
    }

    /**
     * Set left condition/conditionCompare
     *
     * @param DiscountCondition|DiscountConditionCompare $condition
     * @return DiscountConditionCompare|false
     */
    public function setLeftCondition($condition)
    {
        if (is_object($condition) && $condition->getSourceEntityType() != $this->getSourceEntityType()) {
            return false;
        }

        $this->_leftCondition = $condition;
        return $this;
    }

    /**
     * Getter for right condition/conditionCompare
     *
     * @return DiscountCondition|DiscountConditionCompare
     */
    public function getRightCondition()
    {
        return $this->_rightCondition;
    }

    /**
     * Set right condition/conditionCompare
     *
     * @param DiscountCondition|DiscountConditionCompare
     * @return DiscountConditionCompare|false
     */
    public function setRightCondition($condition)
    {
        if (is_object($condition) && $condition->getSourceEntityType() != $this->getSourceEntityType()) {
            return false;
        }

        $this->_rightCondition = $condition;
        return $this;
    }

    /**
     * Mutator
     *
     * @param DiscountCondition|DiscountConditionCompare
     * @return DiscountConditionCompare|false
     */
    public function addCondition($condition)
    {

        if (is_object($condition) && $condition->getSourceEntityType() != $this->getSourceEntityType()) {
            return false;
        }

        if (!$condition instanceof DiscountCondition &&
            !$condition instanceof DiscountConditionCompare) {
            return false;
        }
        
        $this->_conditions[] = $condition;
        return $this;
    }

    
    //removeCondition(), getCondition() not really possible after removing key from arrays

    /**
     * Getter for conditions array
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->_conditions;
    }

    /**
     * Set array of conditions
     *
     * @param array
     * @return DiscountConditionCompare
     */
    public function setConditions($conditions = array())
    {
        $this->_conditions = $conditions;
        return $this;
    }

    /**
     * Export array of conditions as array
     *
     * @param DiscountConditionCompare
     * @return array
     */
    public function getConditionsAsArray($object = null)
    {
        $conditions = array();

        if (is_null($object)) {
            $object = $this;
        }

        if (count($object->getConditions()) > 0) {

            //get linear tree
            foreach($object->getConditions() as $tmpObject) {

               if ($tmpObject instanceof DiscountConditionCompare) {
                    
                    $newObject = new DiscountConditionCompare();
                    if ($tmpObject instanceof DiscountConditionCompare) {
                        $newObject = $tmpObject;
                    } else if ($tmpObject instanceof stdClass) {
                        $newObject->importStdClass($tmpObject);
                    } else if (is_array($tmpObject)) {
                        $newObject->importJson(json_encode($tmpObject));
                    }
                    $conditions[] = $newObject->getConditionsAsArray($newObject);

                } else {
                    
                    $newObject = new DiscountCondition();
                    if ($tmpObject instanceof DiscountCondition) {
                        $newObject = $tmpObject;
                    } else if ($tmpObject instanceof stdClass) {
                        $newObject->importStdClass($tmpObject);
                    } else if (is_array($tmpObject)) {
                        $newObject->importJson(json_encode($tmpObject));
                    }
                    $conditions[] = $newObject->toArray();
                }
            }

        } else if (is_object($object->getLeftCondition()) || is_object($object->getRightCondition())) {
            
            $conditions['left'] = null;
            if (!is_null($object->getLeftCondition())) {
                $conditions['left'] = $object->getLeftCondition()->toArray();
            }
            
            $conditions['right'] = null;
            if (!is_null($object->getRightCondition())) {
                $conditions['right'] = $object->getRightCondition()->toArray();
            }
        
        }

        return $conditions;
    }

    /**
     * Determine whether an object eg Item,Shipment validates this nest of conditions
     *
     * @param Item|Shipment|Customer
     * @return DiscountConditionCompare
     */
    public function isValid($object)
    {

        $left = $this->getLeftCondition();
        $right = $this->getRightCondition();
        $isNot = $this->getIsNot();

        switch($this->getOp()) {
            case 'and':
                if (count($this->getConditions())) {

                    foreach($this->getConditions() as $condition) {
                        if (!$object->isValidCondition($condition)) {
                            return ($isNot) ? true : false;
                        }
                    }

                    return ($isNot) ? false : true;
                } else {

                    if ($left instanceof DiscountCondition && 
                        $right instanceof DiscountCondition) {
                        
                        $result = $object->isValidCondition($left) && $object->isValidCondition($right);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountConditionCompare && 
                            $right instanceof DiscountCondition) {

                        $result = $this->isValid($left, $object) && $object->isValidCondition($right);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountCondition && 
                            $right instanceof DiscountConditionCompare) {

                        $result = $object->isValidCondition($left) && $this->isValid($right, $object);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountConditionCompare && 
                            $right instanceof DiscountConditionCompare) {

                        $result = $this->isValid($left, $object) && $this->isValid($right, $object);
                        return ($isNot) ? !$result : $result;
                    }
                }
                break;
            case 'or':
                if (count($this->getConditions())) {
                    foreach($this->getConditions() as $condition) {
                        if ($object->isValidCondition($condition)) {
                            return ($isNot) ? false : true;
                        }
                    }

                    return ($isNot) ? true : false;
                } else {

                    if ($left instanceof DiscountCondition && 
                        $right instanceof DiscountCondition) {
                        
                        $result = $object->isValidCondition($left) || $object->isValidCondition($right);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountConditionCompare && 
                            $right instanceof DiscountCondition) {

                        $result = $this->isValid($left, $object) || $object->isValidCondition($right);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountCondition && 
                            $right instanceof DiscountConditionCompare) {

                        $result = $object->isValidCondition($left) || $this->isValid($right, $object);
                        return ($isNot) ? !$result : $result;
                    } else if ($left instanceof DiscountConditionCompare && 
                            $right instanceof DiscountConditionCompare) {

                        $result = $this->isValid($left, $object) || $this->isValid($right, $object);
                        return ($isNot) ? !$result : $result;
                    }
                }

                break;
            default:
                //no-op
                break;
        }
        
        return ($isNot) ? true : false;
    }
}
