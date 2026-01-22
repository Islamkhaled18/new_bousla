<?php

namespace App\Helpers;

class IconMapper
{
    /**
     * Map Font Awesome icons to Flutter Material Icons
     * Returns array with unicode codepoint and icon family
     */
    public static function toFlutter(string $fontAwesomeIcon): array
    {
        $iconMap = [
            // Medical Icons
            'fa-hand-sparkles' => ['unicode' => '0xe3e8', 'family' => 'MaterialIcons'], // healing
            'fa-tooth' => ['unicode' => '0xe3e9', 'family' => 'MaterialIcons'], // medical_services
            'fa-brain' => ['unicode' => '0xe3ea', 'family' => 'MaterialIcons'], // psychology
            'fa-baby' => ['unicode' => '0xe3eb', 'family' => 'MaterialIcons'], // child_care
            'fa-bone' => ['unicode' => '0xe923', 'family' => 'MaterialIcons'], // accessible
            'fa-person-dress' => ['unicode' => '0xe7fd', 'family' => 'MaterialIcons'], // person
            'fa-ear-listen' => ['unicode' => '0xe3ec', 'family' => 'MaterialIcons'], // hearing
            'fa-heart-pulse' => ['unicode' => '0xe87e', 'family' => 'MaterialIcons'], // favorite
            'fa-stethoscope' => ['unicode' => '0xe3ed', 'family' => 'MaterialIcons'], // medical_services
            'fa-x-ray' => ['unicode' => '0xf15c', 'family' => 'MaterialIcons'], // image
            'fa-droplet' => ['unicode' => '0xe798', 'family' => 'MaterialIcons'], // water_drop
            'fa-ribbon' => ['unicode' => '0xe8af', 'family' => 'MaterialIcons'], // bookmark
            'fa-apple-whole' => ['unicode' => '0xe3ee', 'family' => 'MaterialIcons'], // restaurant
            'fa-user-nurse' => ['unicode' => '0xe7fd', 'family' => 'MaterialIcons'], // person
            'fa-scissors' => ['unicode' => '0xe14e', 'family' => 'MaterialIcons'], // content_cut
            'fa-heart-circle-bolt' => ['unicode' => '0xe87e', 'family' => 'MaterialIcons'], // favorite
            'fa-face-smile' => ['unicode' => '0xe7fd', 'family' => 'MaterialIcons'], // person
            'fa-weight-scale' => ['unicode' => '0xe3ef', 'family' => 'MaterialIcons'], // monitor_weight
            'fa-user-doctor' => ['unicode' => '0xe3f0', 'family' => 'MaterialIcons'], // local_hospital
            'fa-person' => ['unicode' => '0xe7fd', 'family' => 'MaterialIcons'], // person
            'fa-lungs' => ['unicode' => '0xe3f1', 'family' => 'MaterialIcons'], // air
            'fa-head-side-virus' => ['unicode' => '0xe3ea', 'family' => 'MaterialIcons'], // psychology
            'fa-pills' => ['unicode' => '0xe3f2', 'family' => 'MaterialIcons'], // medication
            'fa-shield-virus' => ['unicode' => '0xe32a', 'family' => 'MaterialIcons'], // shield
            'fa-baby-carriage' => ['unicode' => '0xe3eb', 'family' => 'MaterialIcons'], // child_care
            'fa-hand-dots' => ['unicode' => '0xe3e8', 'family' => 'MaterialIcons'], // healing
            'fa-syringe' => ['unicode' => '0xe3f3', 'family' => 'MaterialIcons'], // vaccines
            'fa-deaf' => ['unicode' => '0xe3ec', 'family' => 'MaterialIcons'], // hearing_disabled
            'fa-people-roof' => ['unicode' => '0xe88a', 'family' => 'MaterialIcons'], // family_restroom
            'fa-person-cane' => ['unicode' => '0xe923', 'family' => 'MaterialIcons'], // accessible
            'fa-paw' => ['unicode' => '0xe91c', 'family' => 'MaterialIcons'], // pets
            'fa-teeth' => ['unicode' => '0xe3e9', 'family' => 'MaterialIcons'], // dental
            'fa-person-walking' => ['unicode' => '0xe536', 'family' => 'MaterialIcons'], // directions_walk
            'fa-eye-dropper' => ['unicode' => '0xe3f4', 'family' => 'MaterialIcons'], // remove_red_eye
            'fa-heartbeat' => ['unicode' => '0xe87e', 'family' => 'MaterialIcons'], // favorite
            'fa-prescription-bottle-medical' => ['unicode' => '0xe3f2', 'family' => 'MaterialIcons'], // medication
            'fa-venus-mars' => ['unicode' => '0xe7fd', 'family' => 'MaterialIcons'], // person
            'fa-comments' => ['unicode' => '0xe0b7', 'family' => 'MaterialIcons'], // chat
        ];

        // Clean the icon name (remove 'fa-' prefix if exists)
        $cleanIcon = str_replace('fa-', '', trim($fontAwesomeIcon));
        $lookupKey = 'fa-' . $cleanIcon;

        // Return mapped icon or default
        return $iconMap[$lookupKey] ?? [
            'unicode' => '0xe3f0', // default: local_hospital
            'family' => 'MaterialIcons'
        ];
    }

    /**
     * Get Flutter-compatible icon data
     */
    public static function getFlutterIconData(string $fontAwesomeIcon): array
    {
        $mapped = self::toFlutter($fontAwesomeIcon);
        
        return [
            'codePoint' => hexdec(str_replace('0x', '', $mapped['unicode'])),
            'fontFamily' => $mapped['family'],
            'unicode' => $mapped['unicode'],
        ];
    }
}