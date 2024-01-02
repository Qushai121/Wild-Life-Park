<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\TransactionModel;

class Checkout extends BaseController
{

    public function __construct(
        private $ticketModel = new TicketModel(),
        private $transactionModel = new TransactionModel()
    ) {
    }
    public function create()
    {
        if (!auth()->user()) {
            return redirect()->back()->with("authMessage", true);
        }
        // Create a new product
        $product = [
            'id' => uniqid(),
            'product_id' => $this->request->getPost('product_id'),
            'quantity' => $this->request->getPost('quantity'),
        ];

        // Get existing products from the cookie
        $existingProducts = json_decode($this->request->getCookie('products'), true) ?? [];

        // Find the product by ID
        $productKey = array_search($product['product_id'], array_column($existingProducts, 'product_id'));
        if ($productKey !== false) {
            // Update the product based on the provided data (you need to customize this part)
            $existingProducts[$productKey]['quantity'] = $existingProducts[$productKey]['quantity'] + $product['quantity'];

            // Set the updated products list in the cookie
            setcookie('products', json_encode($existingProducts), time() + 3600 * 60, '/'); // Set a one-hour expiration
        } else {
            // Add the new product
            $existingProducts[] = $product;

            // Set the updated products list in the cookie
            setcookie('products', json_encode($existingProducts), time() + 3600 * 60, '/'); // Set a one-hour expiration
        }

        // Redirect to a success page or do something else
        return redirect()->to('/ticket');
    }

    public function edit($productId)
    {
        // Get existing products from the cookie
        $existingProducts = json_decode($this->request->getCookie('products'), true) ?? [];

        // Find the product by ID
        $productKey = array_search($productId, array_column($existingProducts, 'id'));
    }

    public function read()
    {
        $data['topbar'] = [
            'title' => 'List Checkout Ticket',
            'description' => 'Pay Your Checkout Ticket To get E-Ticket'
        ];

        // Read products from the cookie
        $listTicketsCookie = json_decode($this->request->getCookie('products'), true) ?? [];
        // dd($listTicketsCookie);
        $productQuantities  = array_column($listTicketsCookie, 'quantity', 'product_id');
        $productCheckOutId  = array_column($listTicketsCookie, 'product_id', 'quantity');

        $tickets = $this->ticketModel->getTicketByManyIds(
            array_keys($productQuantities) ?: [0],
            'id,name,image,description,access,discount,price,qty,totalqrcode'
        );

        $ticketList = [];
        $total = 0;
        $qtyTotal = 0;

        foreach ($tickets as $item) {
            $quantity = $productQuantities[$item['id']];
            $ids = $productCheckOutId[$quantity];
            $qtyTotal += $quantity;
            $total += discountPrice($item['price'], $item['discount']) * $quantity;
            $ticketList[] = [
                'id' => $item['id'],
                'checkoutProductId' => $ids,
                'quantity' => $quantity,
                'total_price_discount' => discountPrice($item['price'], $item['discount']),
                'name' => $item['name'],
                'image' => $item['image'],
                'description' => $item['description'],
                'access' => $item['access'],
                'discount' => $item['discount'],
                'price' => $item['price'],
                'stock' => $item['qty'],
                'totalqrcode' => $item['totalqrcode']
            ];
        }

        $data['listTickets'] = $ticketList;
        $data['total'] = $total;
        $data['qtyTotal'] = $qtyTotal;
        // Display or process the products as needed
        return view('Pages/LandingPages/Checkout/IndexCheckout', $data);
    }

    public function update($productId)
    {
        // Get existing products from the cookie
        $existingProducts = json_decode($this->request->getCookie('products'), true) ?? [];

        // Find the product by ID
        $productKey = array_search($productId, array_column($existingProducts, 'product_id'));

        if ($productKey !== false) {
            if ($existingProducts[$productKey]['quantity'] > 1) {
                if ($this->request->getPost('quantityplus')) {
                    $existingProducts[$productKey]['quantity'] = $existingProducts[$productKey]['quantity'] + 1;
                }
                if ($this->request->getPost('quantityminus')) {
                    $existingProducts[$productKey]['quantity'] = $existingProducts[$productKey]['quantity'] - 1;
                }
                if ($this->request->getPost('quantity')) {
                    $qtyInput = $this->request->getPost('quantity');
                    if ($qtyInput < 1) {
                        $existingProducts[$productKey]['quantity'] = 1;
                    } else {
                        $existingProducts[$productKey]['quantity'] = $this->request->getPost('quantity');
                    }
                }
            } else {
                if ($this->request->getPost('quantity')) {
                    $qtyInput = $this->request->getPost('quantity');
                    if ($qtyInput < 1) {
                        $existingProducts[$productKey]['quantity'] = 1;
                    } else {
                        $existingProducts[$productKey]['quantity'] = $this->request->getPost('quantity');
                    }
                } else {
                    if ($this->request->getPost('quantityplus')) {
                        $existingProducts[$productKey]['quantity'] = 2;
                    }
                }
            }


            // Set the updated products list in the cookie
            setcookie('products', json_encode($existingProducts), time() + 3600 * 60, '/'); // Set a one-hour expiration

            // Redirect or perform other actions
            return redirect()->to('/checkout');
        } else {
            // Handle product not found
            return redirect()->to('/ticket');
        }
    }

    public function delete($productId)
    {
        // Get existing products from the cookie
        $existingProducts = json_decode($this->request->getCookie('products'), true) ?? [];

        // Find the product by ID
        $productKey = array_search($productId, array_column($existingProducts, 'product_id'));
        if ($productKey !== false) {
            // Remove the product from the array
            unset($existingProducts[$productKey]);

            // Reindex the array to ensure keys are continuous
            $existingProducts = array_values($existingProducts);

            // Set the updated products list in the cookie
            setcookie('products', json_encode($existingProducts), time() + 3600 * 60, '/'); // Set a one-hour expiration

            // Redirect or perform other actions
            return redirect()->to('/checkout');
        } else {
            // Handle product not found
            return redirect()->to('/ticket');
        }
    }

    public function deleteCheckoutTicket()
    {
        session()->set('TicketPayment', null);

        setcookie('products', null, time() - 3600 * 60, '/');

        return $this->response->setStatusCode(200);
    }
}
