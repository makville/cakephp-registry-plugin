<?php
namespace MakvilleRegistry\Model\Entity;

use Cake\ORM\Entity;

/**
 * RegistryFieldExtra Entity
 *
 * @property int $id
 * @property int $registry_field_id
 *
 * @property \Registry\Model\Entity\RegistryField $registry_field
 */
class RegistryFieldExtra extends Entity
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
