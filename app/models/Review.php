<?php
/**
 * Review Model
 * Handles CRUD operations and analytics for product reviews
 */

require_once __DIR__ . '/../../config/database.php';

class Review
{
    /**
     * @var mysqli
     */
    private mysqli $db;

    /**
     * Review constructor
     */
    public function __construct()
    {
        global $connection;
        $this->db = $connection;
    }

    /**
     * Create a new review
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO reviews (product_id, user_id, rating, review_text)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "iiis",
            $data['product_id'],
            $data['user_id'],
            $data['rating'],
            $data['review_text']
        );

        return $stmt->execute();
    }

    /**
     * Update an existing review
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE reviews
                SET rating = ?, review_text = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "isi",
            $data['rating'],
            $data['review_text'],
            $id
        );

        return $stmt->execute();
    }

    /**
     * Find a review by ID
     *
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT r.*, u.name AS user_name
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    /**
     * Get reviews for a specific product
     *
     * @param int $productId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getByProduct(int $productId, int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT r.*, u.name AS user_name
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.product_id = ?
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $productId, $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get a review by user and product
     *
     * @param int $userId
     * @param int $productId
     * @return array|null
     */
    public function getByUserAndProduct(int $userId, int $productId): ?array
    {
        $sql = "SELECT *
                FROM reviews
                WHERE user_id = ? AND product_id = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    /**
     * Check if a user has already reviewed a product
     *
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function hasUserReviewedProduct(int $userId, int $productId): bool
    {
        $sql = "SELECT id
                FROM reviews
                WHERE user_id = ? AND product_id = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    /**
     * Get average rating and total reviews for a product
     *
     * @param int $productId
     * @return array
     */
    public function getAverageRating(int $productId): array
    {
        $sql = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews
                FROM reviews
                WHERE product_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        $data = $stmt->get_result()->fetch_assoc();

        return [
            'average' => $data['average_rating'] ? round((float)$data['average_rating'], 1) : 0.0,
            'total'   => (int)$data['total_reviews']
        ];
    }

    /**
     * Get total review count for a product
     *
     * @param int $productId
     * @return int
     */
    public function getTotalCountByProduct(int $productId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS count FROM reviews WHERE product_id = ?"
        );
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        return (int)$stmt->get_result()->fetch_assoc()['count'];
    }

    /**
     * Delete a review
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    /**
     * Get all reviews (Admin)
     *
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit = 10, int $offset = 0): array
    {
        $sql = "SELECT r.*, u.name AS user_name, p.name AS product_name
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN products p ON r.product_id = p.id
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get total count of all reviews
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        $result = $this->db->query("SELECT COUNT(*) AS count FROM reviews");
        return (int)$result->fetch_assoc()['count'];
    }
}
