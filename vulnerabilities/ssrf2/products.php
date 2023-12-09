<?php
// Một mảng chứa danh sách sản phẩm. Bạn có thể cung cấp thông tin sản phẩm thực tế ở đây.
    $products = array(); ;
    include("db_helper.php");
    $sql = "SELECT * FROM product";
    $result = excuteSQL($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($products,[
                "id" => $row["id"],
                "name" => $row["name"],
                "image" => $row["link_image"],

            ]);
            
        }
    } else {
        echo "Không tìm thấy sản phẩm nào.";
    }
?>

<div class="product-container">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <div class="product-image">
                <img src="<?php echo './image/'.$product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="product-details">
                <h3><?php echo $product['name']; ?></h3>
                <a href="product.php?id=<?php echo $product['id'] ?> ">Xem chi tiết</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

