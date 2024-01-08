Category
----------
id (PK)
name
description
createdAt
updatedAt

Product
----------
id (PK)
name
photos
price
description
quantity
createdAt
updatedAt
category_id (FK references Category.id)
