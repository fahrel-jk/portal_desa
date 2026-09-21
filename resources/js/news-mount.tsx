import React from 'react';
import { createRoot } from 'react-dom/client';
import { CardNews } from './components/ui/card-news';

const rootElement = document.getElementById('news-react-root');

if (rootElement) {
    const rawData = rootElement.getAttribute('data-news');
    let items = [];
    
    if (rawData) {
        try {
            items = JSON.parse(rawData);
        } catch (error) {
            console.error("Failed to parse news:", error);
        }
    }

    const root = createRoot(rootElement);
    root.render(
        <React.StrictMode>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {items.map((news: any) => (
                    <CardNews
                        key={news.id}
                        imageUrl={news.image_url}
                        imageAlt={news.title}
                        title={news.title}
                        category={news.category}
                        date={news.published_date}
                        overview={news.overview}
                        url={news.url}
                    />
                ))}
            </div>
        </React.StrictMode>
    );
}
