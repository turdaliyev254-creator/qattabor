# QattaBor Mobile App - React Native

A beautiful mobile app for discovering places in Uzbekistan with AI-powered voice assistant.

## Features

✅ **User Authentication** - Login/Register with phone number
✅ **Categories** - Browse places by category (Food, Cinema, Sport, etc.)
✅ **AI Assistant** - Voice-enabled chat with GPT-4o-mini
✅ **Text-to-Speech** - AI responses spoken aloud
✅ **Search** - Find places quickly
✅ **Multi-language** - Uzbek, Russian, English support
✅ **Beautiful UI** - Modern, clean design

## Prerequisites

- Node.js (v16 or higher)
- npm or yarn
- Expo CLI: `npm install -g expo-cli`
- EAS CLI (for building): `npm install -g eas-cli`

## Installation

```bash
cd qattabor-mobile
npm install
```

## Running the App

### Development Mode

```bash
# Start Expo development server
npm start

# Run on Android
npm run android

# Run on iOS (Mac only)
npm run ios

# Run on web
npm run web
```

## Building for Production

### Setup EAS Build

```bash
# Login to Expo
eas login

# Configure your project
eas build:configure
```

### Build APK (Android)

```bash
# Build APK for testing
npm run build:apk

# Or use EAS directly
eas build --platform android --profile preview
```

### Build for iOS

```bash
# Build for iOS
npm run build:ios

# Or use EAS directly
eas build --platform ios --profile production
```

### Build App Bundle (Google Play)

```bash
eas build --platform android --profile production
```

## Configuration

### Backend API

Update the API URL in `services/aiService.js`:

```javascript
const API_BASE_URL = 'https://your-server.com';
```

### App Icons & Splash Screen

Replace the following files:
- `assets/icon.png` - App icon (1024x1024)
- `assets/adaptive-icon.png` - Android adaptive icon
- `assets/splash.png` - Splash screen (1242x2688)
- `assets/favicon.png` - Web favicon

## Project Structure

```
qattabor-mobile/
├── App.js                      # Main app entry point
├── app.json                    # Expo configuration
├── package.json                # Dependencies
├── eas.json                    # EAS Build configuration
├── screens/
│   ├── LoginScreen.js          # Login/Register screen
│   ├── HomeScreen.js           # Home with categories
│   └── AIAssistantScreen.js    # AI chat interface
├── services/
│   ├── aiService.js            # AI API integration
│   └── voiceService.js         # Text-to-speech service
└── assets/                     # Images and icons
```

## Key Dependencies

- **expo** - Development framework
- **react-navigation** - Navigation between screens
- **expo-speech** - Text-to-speech functionality
- **axios** - HTTP client for API calls
- **react-native-vector-icons** - Icon library
- **@react-native-async-storage/async-storage** - Local storage

## Permissions

### Android
- `INTERNET` - Network access
- `RECORD_AUDIO` - Voice input (future feature)

### iOS
- `NSMicrophoneUsageDescription` - Microphone access
- `NSSpeechRecognitionUsageDescription` - Speech recognition

## Testing

### Android Testing
1. Build APK: `npm run build:apk`
2. Download APK from Expo dashboard
3. Install on Android device
4. Test all features

### iOS Testing (TestFlight)
1. Build for iOS: `npm run build:ios`
2. Download IPA from Expo dashboard
3. Upload to App Store Connect
4. Distribute via TestFlight

## Publishing

### Google Play Store

1. Build app bundle:
```bash
eas build --platform android --profile production
```

2. Download AAB file
3. Upload to Google Play Console
4. Fill in app details
5. Submit for review

### Apple App Store

1. Build for iOS:
```bash
eas build --platform ios --profile production
```

2. Download IPA
3. Upload to App Store Connect via Transporter
4. Fill in app details
5. Submit for review

## Troubleshooting

### Build Fails
- Check `eas.json` configuration
- Verify all dependencies are installed
- Check Expo SDK compatibility

### App Crashes
- Check console logs: `expo start`
- Verify API endpoint is accessible
- Check AsyncStorage permissions

### Voice Not Working
- Verify device audio settings
- Check expo-speech installation
- Test on physical device (not simulator)

## Environment Variables

For production, update these in your app:

- API URL in `services/aiService.js`
- Bundle identifiers in `app.json`
- EAS project ID in `app.json`

## Support

For issues or questions:
- Check Expo documentation: https://docs.expo.dev
- React Native docs: https://reactnative.dev
- Open an issue in the repository

## License

MIT License - Free to use and modify
