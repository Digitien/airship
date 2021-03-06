<?php
declare(strict_types=1);
namespace Airship\Engine\Security\Filter;

/**
 * Class FloatArrayFilter
 * @package Airship\Engine\Security\Filter
 */
class FloatArrayFilter extends ArrayFilter
{
    /**
     * @var float
     */
    protected $default = 0.0;

    /**
     * @var string
     */
    protected $type = 'float[]';

    /**
     * Apply all of the callbacks for this filter.
     *
     * @param mixed $data
     * @param int $offset
     * @return mixed
     * @throws \TypeError
     */
    public function applyCallbacks($data = null, int $offset = 0)
    {
        if ($offset === 0) {
            if (\is_null($data)) {
                return parent::applyCallbacks($data, 0);
            } elseif (!\is_array($data)) {
                throw new \TypeError(
                    \sprintf('Expected an array of floats (%s).', $this->index)
                );
            }
            if (!\is1DArray($data)) {
                throw new \TypeError(
                    \sprintf('Expected a 1-dimensional array (%s).', $this->index)
                );
            }
            foreach ($data as $key => $val) {
                if (\is_array($val)) {
                    throw new \TypeError(
                        \sprintf('Expected a float at index %s (%s).', $key, $this->index)
                    );
                }
                if (\is_int($val) || \is_float($val)) {
                    $data[$key] = (float) $val;
                } elseif (\is_null($val) || $val === '') {
                    $data[$key] = (float) $this->default;
                } elseif (\is_string($val) && \is_numeric($val)) {
                    $data[$key] = (float) $val;
                } else {
                    throw new \TypeError(
                        \sprintf('Expected a float at index %s (%s).', $key, $this->index)
                    );
                }
            }
            return parent::applyCallbacks($data, 0);
        }
        return parent::applyCallbacks($data, $offset);
    }
}
