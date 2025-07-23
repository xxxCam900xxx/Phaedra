<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/config/database.php";

/**
 * Gibt die aktuellste Webdesign-Konfiguration aus der Datenbank zurück.
 * @return array|null
 */
function getWebDesign(): ?array
{
    $stmt = executeStatement("SELECT * FROM WebDesign ORDER BY ID DESC LIMIT 1");

    $stmt->bind_result(
        $id,
        $primaryColor,
        $secondaryColor,
        $backgroundColor,
        $heading1Size,
        $heading2Size,
        $paragraphSize,
        $heading1Weight,
        $heading2Weight,
        $paragraphWeight,
        $linkColor,
        $linkHoverColor,
        $linkBtn_TextColor,
        $linkBtn_Color,
        $linkHoverBtn_Color,
        $section_Gap,
        $footerColor,
        $footerBackgroundColor,
        $footerLinkColor,
        $footerEndColor,
        $footerEndBackgroundColor,
        $headerBackgroundColor,
        $headerLinkColor,
        $preHeaderColor,
        $preHeaderBackgroundColor,
    );

    if ($stmt->fetch()) {
        return [
            'success' => true,
            'data' => [
                'Primary_Color'             => $primaryColor,
                'Secondary_Color'           => $secondaryColor,
                'Background_Color'          => $backgroundColor,

                'Heading1_Size'             => $heading1Size,
                'Heading2_Size'             => $heading2Size,
                'Paragraph_Size'            => $paragraphSize,

                'Heading1_Weight'           => $heading1Weight,
                'Heading2_Weight'           => $heading2Weight,
                'Paragraph_Weight'          => $paragraphWeight,

                'Link_Color'                => $linkColor,
                'LinkHover_Color'           => $linkHoverColor,

                'LinkBtn_TextColor'         => $linkBtn_TextColor,
                'LinkBtn_Color'             => $linkBtn_Color,
                'LinkHoverBtn_Color'        => $linkHoverBtn_Color,

                'Section_Gap'               => $section_Gap,

                'Footer_Color'              => $footerColor,
                'Footer_BackgroundColor'    => $footerBackgroundColor,
                'Footer_LinkColor'          => $footerLinkColor,

                'FooterEnd_BackgroundColor' => $footerEndBackgroundColor,
                'FooterEnd_Color'           => $footerEndColor,

                'Header_BackgroundColor'    => $headerBackgroundColor,
                'Header_LinkColor'          => $headerLinkColor,

                'PreHeader_Color'           => $preHeaderColor,
                'PreHeader_BackgroundColor' => $preHeaderBackgroundColor,
            ]
        ];
    }

    return null;
}
