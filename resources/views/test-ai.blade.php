<!DOCTYPE html>
<html>
<head>
    <title>AI Search Test</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: Arial; padding: 40px; max-width: 600px; margin: 0 auto; }
        input { padding: 10px; width: 100%; font-size: 16px; margin-bottom: 10px; }
        button { padding: 10px 20px; background: purple; color: white; border: none; cursor: pointer; font-size: 16px; }
        button:disabled { opacity: 0.5; cursor: not-allowed; }
        .response { margin-top: 20px; padding: 15px; background: #f0f0f0; border-radius: 5px; }
        .error { background: #ffebee; color: #c62828; }
        .success { background: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>
    <h1>AI Search Test</h1>
    <p>API Key: <strong>{{ config('services.gemini.api_key') ? 'Configured ✓' : 'Missing ✗' }}</strong></p>
    
    <div x-data="{
        query: 'restaurant',
        loading: false,
        response: null,
        error: null
    }">
        <input type="text" x-model="query" placeholder="Enter search query...">
        
        <button 
            @click="
                loading = true;
                response = null;
                error = null;
                fetch('/search/ai', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ query: query })
                })
                .then(r => r.json())
                .then(data => {
                    loading = false;
                    response = JSON.stringify(data, null, 2);
                    console.log('Success:', data);
                })
                .catch(err => {
                    loading = false;
                    error = err.message;
                    console.error('Error:', err);
                });
            "
            :disabled="loading || query.length < 2"
            x-text="loading ? 'Thinking...' : 'Test AI Search'"
        ></button>
        
        <div x-show="loading" style="margin-top: 20px;">⏳ Loading...</div>
        
        <div x-show="response" class="response success">
            <strong>Response:</strong>
            <pre x-text="response"></pre>
        </div>
        
        <div x-show="error" class="response error">
            <strong>Error:</strong>
            <p x-text="error"></p>
        </div>
    </div>
    
    <hr style="margin: 30px 0;">
    <h3>Debug Info:</h3>
    <ul>
        <li>Route: POST /search/ai</li>
        <li>CSRF Token: {{ csrf_token() }}</li>
        <li>Gemini API: {{ config('services.gemini.api_key') ? 'Yes' : 'No' }}</li>
    </ul>
</body>
</html>
