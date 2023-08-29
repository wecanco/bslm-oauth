 
# baSalam-auth
## Work flow

- installation

- usage



### Installation

to install this package use blew command:

`composer require basalam-auth/auth`

### Usage

after that you must run `php artisan vendor:publish` for publish package and copy php config file from package to project.


#### Permissions list

| توضیحات دسترسی                                              | نام دسترسی             |
| ----------------------------------------------------------- | ---------------------- |
| خواندن اطلاعات کیف پول مشتری                                | customer.wallet.read   |
| استفاده از اعتبار مشتری و ایجاد درخواست نقد کردن برای مشتری | customer.wallet.write  |
| خواندن لیست و جزییات سفارشات مشتری                          | customer.order.read    |
| انجام عملیات روی سفارشات مشتری                              | customer.order.write   |
| خواندن جزییات اطلاعات مشتری                                 | customer.profile.read  |
| ویرایش جزییات اطلاعات مشتری                                 | customer.profile.write |
| خواندن لیست و جزییات سفارشات غرفه‌دار                        | vendor.order.read      |
| انجام عملیات روی سفارشات غرفه‌دار                            | vendor.order.write     |
| خواندن جزییات اطلاعات غرفه‌دار                               | vendor.profile.read    |
| ویرایش جزییات اطلاعات غرفه‌دار                               | vendor.profile.write   |
| خواندن لیست و جزییات محصولات غرفه‌دار                        | vendor.product.read    |
| ویرایش اطلاعات محصولات غرفه‌دار                              | vendor.product.write   |
