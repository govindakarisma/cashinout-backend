<?php

function formatPrice($value)
{
  return str_replace(',', '.', number_format($value));
}
