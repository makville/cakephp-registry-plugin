<?php
namespace MakvilleRegistry\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegistryField Entity
 *
 * @property int $id
 * @property int $registry_id
 * @property string $name
 * @property string $label
 * @property string $tip
 * @property string $data_type
 * @property string $control_type
 * @property string $options
 *
 * @property \Registry\Model\Entity\Registry $registry
 * @property \Registry\Model\Entity\RegistryFieldExtra[] $registry_field_extras
 */
class RegistryField extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
