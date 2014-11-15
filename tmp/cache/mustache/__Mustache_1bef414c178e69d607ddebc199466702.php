<?php

class __Mustache_1bef414c178e69d607ddebc199466702 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . 'hello ';
        $value = $this->resolveValue($context->find('world'), $context, $indent);
        $buffer .= htmlspecialchars($value, 2, 'UTF-8');
        $buffer .= '!';

        return $buffer;
    }
}
