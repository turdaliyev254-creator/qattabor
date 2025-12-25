# AI Search Configuration

This application includes an AI-powered search feature that can provide intelligent search results using natural language processing.

## Setup Instructions

### 1. Basic Search (No AI Required)
The search functionality works out of the box without any AI configuration. Users can search for:
- Places (by name, description, address)
- Categories
- Subcategories
- Locations

### 2. AI-Enhanced Search (Optional)

To enable AI-powered search suggestions, you need to configure one of the following AI services:

#### Option A: OpenAI (ChatGPT)
1. Get an API key from https://platform.openai.com/api-keys
2. Add to your `.env` file:
   ```
   OPENAI_API_KEY=sk-your-api-key-here
   ```

#### Option B: Google Gemini
1. Get an API key from https://makersuite.google.com/app/apikey
2. Add to your `.env` file:
   ```
   GEMINI_API_KEY=your-gemini-api-key-here
   ```

**Note:** You only need to configure one AI service. The system will automatically use OpenAI if configured, otherwise it will fall back to Gemini.

## Features

### Regular Search
- **Fast autocomplete**: Get instant suggestions as you type
- **Multi-category search**: Search across places, categories, and locations
- **Smart filtering**: Results are organized by type for easy browsing

### AI Search
- **Natural language understanding**: Ask questions like "Where can I find good restaurants?" or "Show me parks nearby"
- **Intelligent recommendations**: AI analyzes your query and suggests the best matches
- **Context-aware responses**: Get personalized suggestions based on available places

## Usage

### For Users
1. Click the search button in the navigation bar
2. Type your search query
3. See instant autocomplete suggestions
4. Click "Ask AI Assistant" for intelligent recommendations (if AI is configured)

### For Developers

#### Search Controller
Location: `app/Http/Controllers/SearchController.php`

Methods:
- `index()` - Display search page
- `aiSearch()` - Process AI-powered search (POST)
- `autocomplete()` - Get autocomplete suggestions (GET)

#### Routes
- `GET /search` - Search page
- `POST /search/ai` - AI search endpoint
- `GET /search/autocomplete` - Autocomplete API

#### Customization

**Modify search algorithm:**
Edit the `performSearch()` method in `SearchController.php`

**Change AI prompts:**
Edit `getOpenAiInterpretation()` or `getGeminiInterpretation()` methods

**Adjust result limits:**
Modify the `limit()` values in the search queries

## API Response Format

### Autocomplete Response
```json
[
  {
    "id": 1,
    "name": "Place Name",
    "type": "place",
    "category": "Category Name",
    "url": "/places/place-slug"
  }
]
```

### AI Search Response
```json
{
  "success": true,
  "query": "search query",
  "results": {
    "places": [...],
    "categories": [...],
    "subcategories": [...],
    "locations": [...]
  },
  "ai_interpretation": "AI response text",
  "total_results": 10
}
```

## Performance Tips

1. **Database Indexing**: Add indexes to frequently searched columns:
   ```sql
   ALTER TABLE places ADD INDEX idx_name (name);
   ALTER TABLE places ADD INDEX idx_description (description);
   ```

2. **Caching**: Consider caching popular search queries:
   ```php
   Cache::remember("search:{$query}", 3600, function() use ($query) {
       return $this->performSearch($query);
   });
   ```

3. **Rate Limiting**: Protect AI endpoints from abuse:
   ```php
   Route::post('/search/ai', [SearchController::class, 'aiSearch'])
       ->middleware('throttle:10,1'); // 10 requests per minute
   ```

## Troubleshooting

### AI Search Not Working
- Check if API keys are correctly set in `.env`
- Verify API key has sufficient credits/quota
- Check Laravel logs: `storage/logs/laravel.log`

### Slow Search Performance
- Add database indexes
- Implement search result caching
- Consider using Laravel Scout with Algolia/Meilisearch for full-text search

### No Autocomplete Suggestions
- Ensure JavaScript is enabled
- Check browser console for errors
- Verify the autocomplete route is accessible

## Security Considerations

1. **API Key Protection**: Never commit API keys to version control
2. **Rate Limiting**: Implement rate limiting on search endpoints
3. **Input Sanitization**: All search inputs are properly escaped
4. **CSRF Protection**: All POST requests include CSRF tokens

## Future Enhancements

- [ ] Voice search integration
- [ ] Image-based search
- [ ] Search history and suggestions
- [ ] Advanced filters (price, rating, distance)
- [ ] Geolocation-based search
- [ ] Multi-language search support
- [ ] Search analytics dashboard

## Credits

- OpenAI GPT-3.5 for AI-powered search
- Google Gemini Pro for alternative AI backend
- Laravel Framework for robust backend
- Alpine.js for reactive UI components
