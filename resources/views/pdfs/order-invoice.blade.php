<html lang="en">
<head>
    <title>POS Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="p-4">
    <!-- Invoice Header -->
    <div class="invoice-head text-center mb-4">
        <img src="/logo/1732239161.phtml" alt="Logo" class="h-8 mx-auto mb-2">
        <h4 class="text-base font-semibold">LaundryBox</h4>
        <p class="text-sm text-gray-700">Okpoii Gonno - 23321</p>
        <p class="text-sm text-gray-700">+024456962357</p>
        <p class="text-sm text-gray-700">demo@demo.com</p>
        <p class="text-sm text-gray-700">TVA</p>
    </div>

    <!-- Invoice Details -->
    <div class="invoice-details border-t pt-4">
        <div class="invoice-list">
            <!-- Title -->
            <div class="text-center my-4">
                <h4 class="text-lg font-bold">Tax Invoice</h4>
            </div>

            <!-- Invoice To -->
            <div class="mb-4">
                <p class="text-sm font-medium">Invoice To:</p>
                <p class="text-sm">Jean Louis Billon</p>
                <p class="text-sm">+0244 2250799664433</p>
                <p class="text-sm">jlbillon@gmail.ccom</p>
                <p class="text-sm">Cocody palmeraie</p>
            </div>

            <!-- Order Details -->
            <div class="space-y-2 mb-4">
                <div class="flex justify-between">
                    <p class="text-sm font-medium">Order No:</p>
                    <p class="text-sm font-bold">ORD-1456</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-sm font-medium">Order Date:</p>
                    <p class="text-sm font-bold">03/12/2024</p>
                </div>
                <div class="flex justify-between">
                    <p class="text-sm font-medium">Delivery Date:</p>
                    <p class="text-sm font-bold">03/12/2024</p>
                </div>
            </div>

            <!-- Items Table -->
            <div>
                <div class="flex justify-between text-sm font-bold text-gray-700 border-b pb-2">
                    <p>Name</p>
                    <p>QTY</p>
                    <p>Total</p>
                </div>
                <div class="flex justify-between items-center text-sm py-2 border-b">
                    <div>
                        <p class="font-medium">Towel</p>
                        <p class="text-gray-500">[Dry Cleaning]</p>
                    </div>
                    <p>1</p>
                    <p>0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Footer -->
    <div class="invoice-footer mt-4 border-t pt-4">
        <div class="space-y-2">
            <div class="flex justify-between">
                <p class="text-sm font-medium">Sub Total:</p>
                <p class="text-sm">0</p>
            </div>
            <div class="flex justify-between">
                <p class="text-sm font-medium">Addon:</p>
                <p class="text-sm">0</p>
            </div>
            <div class="flex justify-between">
                <p class="text-sm font-medium">Discount:</p>
                <p class="text-sm">0</p>
            </div>
            <div class="flex justify-between">
                <p class="text-sm font-medium">Tax (11%):</p>
                <p class="text-sm">0</p>
            </div>
            <div class="flex justify-between font-bold text-gray-900">
                <p>Gross Total:</p>
                <p>0</p>
            </div>
            <div class="flex justify-between">
                <p class="text-sm font-medium">Paid Amount:</p>
                <p class="text-sm">0</p>
            </div>
            <div class="flex justify-between">
                <p class="text-sm font-medium">Customer Balance:</p>
                <p class="text-sm">12769.8 Dr</p>
            </div>
        </div>
        <hr class="my-4">
    </div>

    <!-- Invoice Footer -->
    <div class="text-center text-gray-500 text-sm">
        <p>Powered By LaundryBox</p>
    </div>
</div>

</body>
</html>
