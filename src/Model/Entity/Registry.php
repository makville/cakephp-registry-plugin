<?php
declare(strict_types=1);

namespace MakvilleRegistry\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registry Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $db_name
 * @property string|null $description
 * @property int $owner
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \MakvilleRegistry\Model\Entity\RegistryField[] $registry_fields
 */
class Registry extends Entity
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
        'name' => true,
        'db_name' => true,
        'description' => true,
        'owner' => true,
        'created' => true,
        'modified' => true,
        'registry_fields' => true,
    ];
}
