#!/bin/bash

echo "🚀 Building static site for GitHub Pages..."

# Build assets
echo "📦 Building assets..."
npm run build

# Generate static site
echo "🔧 Generating static HTML files..."
php artisan site:generate

echo "✅ Static site generated in ../docs/"
echo ""
echo "📁 Generated files:"
ls -la ../docs/

echo ""
echo "🌐 To test locally, you can use a simple HTTP server:"
echo "   cd ../docs && python3 -m http.server 8000"
echo "   Then open: http://localhost:8000"