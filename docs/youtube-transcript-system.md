# YouTube Transcript Processing System

## Overview

This system automatically retrieves transcripts from YouTube videos, processes them using an AI provider, and generates refined content based on a predefined system prompt.

## Architecture

```
┌─────────────────┐
│   User Request  │
│  (Video URL)    │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────────┐
│ YouTubeContentController       │
│ - Validates input               │
│ - Extracts video ID             │
│ - Coordinates workflow          │
└────────┬────────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│ TranscriptApiService            │
│ - Fetches transcript from API   │
│ - Implements retry logic         │
│ - Normalizes transcript text    │
└────────┬────────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│ AiProcessingService             │
│ - Processes transcript with AI   │
│ - Uses configured system prompt  │
│ - Returns structured JSON       │
└────────┬────────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│ Database Storage                │
│ - Videos table                  │
│ - AI Outputs table              │
│ - AI Request Logs table         │
└─────────────────────────────────┘
```

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Transcript API Configuration
TRANSCRIPT_API_KEY=sk_7K1cVkAZHH-j9NUIo3hhwbr-HneVpIn8URg8JyXUXfQ

# AI Provider Configuration (example for OpenAI)
OPENAI_API_KEY=your-openai-api-key
OPENAI_BASE_URL=https://api.openai.com/v1
OPENAI_MODEL=gpt-3.5-turbo
```

### Service Configuration

The transcript API is configured in `config/services.php`:

```php
'transcript_api' => [
    'key' => env('TRANSCRIPT_API_KEY'),
    'base_url' => 'https://transcriptapi.com/api/v2',
],
```

## API Endpoints

### Generate Content from YouTube Video

**POST** `/admin/youtube-content/generate`

**Request Body:**
```json
{
  "url_or_id": "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
  "system_prompt": "Optional custom system prompt",
  "provider_id": 1
}
```

**Parameters:**
- `url_or_id` (required): YouTube video URL or 11-character video ID
- `system_prompt` (optional): Custom system prompt for AI processing
- `provider_id` (optional): Specific AI provider ID to use

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "summary": "Concise summary of the video content.",
    "key_points": ["Point 1", "Point 2", "Point 3"],
    "action_items": ["Action 1", "Action 2"],
    "tone": "Educational",
    "sentiment": "Positive",
    "target_audience": "Developers",
    "difficulty_level": "Intermediate"
  },
  "metadata": {
    "source_video": "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
    "video_id": "dQw4w9WgXcQ",
    "processing_time_seconds": 3.45,
    "provider_used": "OpenAI",
    "transcript_length": 12500,
    "timestamp": "2024-01-26T12:00:00.000Z"
  }
}
```

**Error Responses:**

400 - Bad Request
```json
{
  "success": false,
  "message": "No active AI Provider found. Please configure an AI provider first."
}
```

404 - Not Found
```json
{
  "success": false,
  "message": "Video not found or transcript not available."
}
```

429 - Rate Limit
```json
{
  "success": false,
  "message": "Rate limit exceeded. Please try again later."
}
```

500 - Internal Server Error
```json
{
  "success": false,
  "message": "Failed to fetch transcript after trying multiple strategies. Attempts: ..."
}
```

## Features

### 1. Transcript Retrieval

- **Multiple URL Format Support**: Handles standard YouTube URLs, shortened URLs, and direct video IDs
- **Retry Logic**: Implements exponential backoff for transient failures
- **Error Handling**: Distinguishes between permanent and temporary errors
- **Text Normalization**: Removes timestamps, speaker labels, and extra whitespace

### 2. AI Processing

- **Configurable System Prompts**: Use default or custom prompts for different use cases
- **Multiple AI Providers**: Support for OpenAI, Anthropic, and OpenAI-compatible APIs
- **Retry Mechanism**: Automatic retries for transient AI API failures
- **JSON Response Validation**: Ensures AI returns valid, parseable JSON

### 3. Data Storage

- **Video Records**: Stores video metadata, transcripts, and processing status
- **AI Outputs**: Saves generated content with provider information
- **Request Logs**: Tracks all AI requests for monitoring and debugging

### 4. Error Handling & Logging

- **Comprehensive Logging**: Detailed logs at every stage of processing
- **Graceful Degradation**: Continues processing even when some steps fail
- **User-Friendly Errors**: Clear error messages without exposing sensitive data
- **Monitoring Support**: Logs include timing, token usage, and success/failure status

## Default System Prompt

The default system prompt instructs the AI to:

1. Provide a concise 2-3 sentence summary
2. Extract 4-5 key points
3. Identify 2-3 actionable items
4. Determine the video's tone (Educational, Inspirational, Technical, etc.)
5. Analyze sentiment (Positive, Neutral, Negative)
6. Identify target audience
7. Assess difficulty level (Beginner, Intermediate, Advanced)

## Custom System Prompts

You can provide custom system prompts for different use cases:

### Example 1: Technical Documentation
```
Analyze this technical tutorial and generate documentation in JSON format:
{
  "title": "Tutorial title",
  "prerequisites": ["Prereq 1", "Prereq 2"],
  "steps": [{"step": 1, "instruction": "..."}, ...],
  "code_examples": [{"language": "...", "code": "..."}],
  "common_issues": [{"issue": "...", "solution": "..."}]
}
```

### Example 2: Meeting Notes
```
Extract meeting notes from this transcript in JSON format:
{
  "attendees": ["Person 1", "Person 2"],
  "agenda_items": [{"item": "...", "discussion": "..."}],
  "decisions_made": ["Decision 1", "Decision 2"],
  "action_items": [{"task": "...", "assignee": "...", "due_date": "..."}],
  "next_meeting": "Date and time"
}
```

## Error Scenarios & Solutions

### Transcript Not Available

**Error Message:**
```
Failed to fetch transcript after trying multiple strategies. Attempts: 
Transcript track exists but returned no content (possibly region-locked or corrupted)
```

**Possible Causes:**
1. Video has no captions enabled
2. Captions are auto-generated but not available in your region
3. Video is private or restricted
4. Transcript API is experiencing issues

**Solutions:**
1. Verify the video is public and has captions
2. Try a different video with confirmed captions
3. Check the transcript API status
4. Wait and retry (transient errors are retried automatically)

### Authentication Failed

**Error Message:**
```
Authentication failed. Please check your API key.
```

**Solution:**
Verify your `TRANSCRIPT_API_KEY` is correctly set in `.env` and matches the format `sk_...`

### Rate Limit Exceeded

**Error Message:**
```
Rate limit exceeded. Please try again later.
```

**Solution:**
Wait before making additional requests. The system implements exponential backoff for retries.

### AI Provider Not Configured

**Error Message:**
```
No active AI Provider found. Please configure an AI provider first.
```

**Solution:**
1. Create an AI provider in the admin panel
2. Ensure it's marked as active
3. Set it as default if you want it used automatically

## Performance

### Response Time Targets

- **Target**: Under 10 seconds for 95% of requests
- **Typical**: 3-7 seconds for most videos
- **Factors affecting time**:
  - Transcript length
  - AI provider response time
  - Network latency
  - API rate limiting

### Optimization Tips

1. **Use Default AI Provider**: Avoid specifying provider_id if you have a default
2. **Cache Results**: Store generated content to avoid reprocessing
3. **Batch Processing**: Use queue jobs for processing multiple videos
4. **Monitor Logs**: Check logs for slow operations

## Security

### API Key Management

- API keys are stored in environment variables
- Never commit `.env` files to version control
- Use secret management in production (e.g., AWS Secrets Manager, Azure Key Vault)
- Keys are never logged or exposed in error messages

### YouTube Terms of Service

This system complies with YouTube's Terms of Service by:
- Only processing publicly available videos
- Not storing video content, only transcripts
- Not redistributing copyrighted material
- Using transcripts for analysis purposes only

## Monitoring & Debugging

### Log Files

Check `storage/logs/laravel.log` for detailed information:

```bash
# View recent logs
tail -f storage/logs/laravel.log

# Search for specific video
grep "dQw4w9WgXcQ" storage/logs/laravel.log

# Search for errors
grep "ERROR" storage/logs/laravel.log
```

### Database Queries

Monitor AI request logs:

```sql
-- View recent successful requests
SELECT * FROM ai_request_logs 
WHERE status = 'success' 
ORDER BY created_at DESC 
LIMIT 10;

-- View failed requests
SELECT * FROM ai_request_logs 
WHERE status = 'failed' 
ORDER BY created_at DESC;

-- Average processing time
SELECT 
    AVG(processing_time) as avg_time,
    MIN(processing_time) as min_time,
    MAX(processing_time) as max_time
FROM ai_request_logs 
WHERE status = 'success';
```

## Testing

Run the test suite:

```bash
# Run all YouTube content tests
php artisan test --filter YouTubeContentGenerationTest

# Run specific test
php artisan test --filter test_successful_youtube_content_generation
```

## Queue Processing

For processing multiple videos, use the queue system:

```bash
# Start the queue worker
php artisan queue:work --queue=youtube-processing

# Dispatch a video for processing
ProcessYouTubeVideo::dispatch($video);
```

## Troubleshooting Checklist

1. ✅ Verify API keys are set in `.env`
2. ✅ Check video is public and has captions
3. ✅ Ensure AI provider is configured and active
4. ✅ Review logs for specific error messages
5. ✅ Test with a known working video
6. ✅ Check network connectivity
7. ✅ Verify queue worker is running (if using queues)
8. ✅ Monitor rate limits

## Support

For issues or questions:
1. Check the logs first
2. Review this documentation
3. Consult the error message details
4. Check the transcript API documentation: https://transcriptapi.com/swagger

## Future Enhancements

Potential improvements:
- Support for multiple transcript languages
- Transcript caching to reduce API calls
- Real-time progress updates
- Batch processing endpoint
- Custom output templates
- Integration with video metadata APIs
- Support for live streams
- Sentiment analysis over time
- Topic modeling and clustering
