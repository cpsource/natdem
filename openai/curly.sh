#!/bin/bash
curl https://api.openai.com/v1/chat/completions \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer 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" \
  -d '{
     "model": "gpt-4o",
     "messages": [{"role": "user", "content": "Tell me about opcache."}],
     "temperature": 0.7
   }'
