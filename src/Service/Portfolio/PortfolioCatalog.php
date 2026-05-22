<?php

namespace App\Service\Portfolio;

/**
 * Shared portfolio gallery (landing preview + full /portfolio page).
 */
final class PortfolioCatalog
{
    /**
     * @return list<array{id: string, title: string, subtitle: string|null, image: string, category: string, featured: bool}>
     */
    public function all(): array
    {
        return array_merge($this->featuredItems(), $this->galleryItems());
    }

    /**
     * @return array{id: string, title: string, subtitle: string|null, image: string, category: string, featured: bool}|null
     */
    public function find(string $id): ?array
    {
        foreach ($this->all() as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return list<array{id: string, title: string, subtitle: string|null, image: string, category: string, featured: bool}>
     */
    public function featured(): array
    {
        return array_values(array_filter($this->all(), static fn (array $item): bool => $item['featured']));
    }

    /**
     * @return list<array{id: string, title: string, subtitle: string|null, image: string, category: string, featured: bool}>
     */
    private function featuredItems(): array
    {
        return [
            [
                'id' => 'elegant-wedding-reception',
                'title' => 'Elegant Wedding Reception',
                'subtitle' => 'Grand celebration with stunning decorations',
                'image' => 'https://i.pinimg.com/736x/f0/7d/96/f07d96670ccf8acd5aea53f2dbf2c13d.jpg',
                'category' => 'Wedding',
                'featured' => true,
            ],
            [
                'id' => 'romantic-wedding-ceremony',
                'title' => 'Romantic Wedding Ceremony',
                'subtitle' => 'Beautiful outdoor wedding ceremony',
                'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Wedding',
                'featured' => true,
            ],
            [
                'id' => 'stunning-wedding-decoration',
                'title' => 'Stunning Wedding Decoration',
                'subtitle' => 'Exquisite floral arrangements and styling',
                'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Wedding',
                'featured' => true,
            ],
            [
                'id' => 'colorful-birthday-celebration',
                'title' => 'Colorful Birthday Celebration',
                'subtitle' => 'Vibrant birthday party with themed decorations',
                'image' => 'https://i.pinimg.com/736x/9e/34/f9/9e34f9894ea2c731a3158422d7227fab.jpg',
                'category' => 'Birthday',
                'featured' => true,
            ],
            [
                'id' => 'fun-birthday-celebration',
                'title' => 'Fun Birthday Celebration',
                'subtitle' => 'Joyful birthday party with decorations and cake',
                'image' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Birthday',
                'featured' => true,
            ],
            [
                'id' => 'beautiful-birthday-setup',
                'title' => 'Beautiful Birthday Setup',
                'subtitle' => 'Picture-perfect birthday event arrangement',
                'image' => 'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?auto=format&fit=crop&w=1200&q=80',
                'category' => 'Birthday',
                'featured' => true,
            ],
        ];
    }

    /**
     * @return list<array{id: string, title: string, subtitle: string|null, image: string, category: string, featured: bool}>
     */
    private function galleryItems(): array
    {
        $items = [
            ['reyes-santos-wedding', 'Reyes–Santos ballroom wedding', 'img/7a42239a-ff60-4697-a65c-af925a8d9a8c.jpg', 'Wedding'],
            ['garden-vows-dinner', 'Garden vows & dinner under lights', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&w=1200&q=80', 'Wedding'],
            ['intimate-hotel-celebration', 'Intimate hotel celebration', 'img/36c2e3ca-0b4f-4dd7-8673-3776559757f9.jpg', 'Wedding'],
            ['meridian-tech-gala', 'Meridian Tech year-end gala', 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80', 'Corporate'],
            ['sunset-terrace-reception', 'Sunset terrace reception', 'img/b6de7a81-a844-49fe-9a20-7582386a7a42.jpg', 'Wedding'],
            ['liams-golden-birthday', "Liam's golden birthday", 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&w=1200&q=80', 'Birthday'],
            ['floral-arch-aisle', 'Floral arch & aisle styling', 'img/c38db778-7662-4d48-a839-074de2884384.jpg', 'Wedding'],
            ['award-night-lighting', 'Award night & stage lighting', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80', 'Corporate'],
            ['candlelit-long-table', 'Candlelit long-table dinner', 'img/7363b3de-2e89-40f5-89de-31f63980d295.jpg', 'Wedding'],
            ['ocean-view-cocktail', 'Ocean-view cocktail hour', 'img/740efeff-4868-46fd-8878-ee9bd2acff58.jpg', 'Celebration'],
            ['winter-sweet-sixteen', 'Winter wonderland sweet sixteen', 'https://images.unsplash.com/photo-1606983340126-99ab4feaa64a?auto=format&fit=crop&w=1200&q=80', 'Birthday'],
            ['heritage-church-exit', 'Heritage church exit & confetti', 'img/5846b9a4-8df3-41ad-9c07-a07915a564ee.jpg', 'Wedding'],
            ['rooftop-anniversary', 'Rooftop anniversary soirée', 'img/754e11f3-b98a-43ab-9de0-f985a2c0b73d.jpg', 'Celebration'],
            ['lakeside-graduation', 'Lakeside graduation party', 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&w=1200&q=80', 'Celebration'],
        ];

        return array_map(static fn (array $row): array => [
            'id' => $row[0],
            'title' => $row[1],
            'subtitle' => null,
            'image' => $row[2],
            'category' => $row[3],
            'featured' => false,
        ], $items);
    }
}
