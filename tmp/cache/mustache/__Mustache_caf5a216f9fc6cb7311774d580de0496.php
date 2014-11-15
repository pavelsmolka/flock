<?php

class __Mustache_caf5a216f9fc6cb7311774d580de0496 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . 'hello ';
        $value = $this->resolveValue($context->find('world'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '!
';
        $buffer .= $indent . 'oj';

        return $buffer;
    }
}
