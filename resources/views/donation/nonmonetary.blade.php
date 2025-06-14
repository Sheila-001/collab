<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Non-Monetary Donation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #B7E4FA;
        }
    </style>
</head>
<body class="min-h-screen bg-[#B7E4FA] flex flex-col">
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-4xl p-8 relative">
            <!-- Close Button -->
            <button onclick="window.location.href='/'" class="absolute right-6 top-6 text-[#0A90A4] hover:text-[#0A90A4]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-2xl md:text-3xl font-bold text-black text-center mb-2">Non-Monetary Donation</h2>
            <p class="text-lg text-black text-center mb-8">Your generosity makes a difference</p>
            
            <form id="donationForm" action="{{ route('non_monetary.submit') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf

                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Category</label>
                        <select name="category" id="category" required class="w-full px-4 py-2.5 bg-white border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                            <option value="">Select Category</option>
                            <option value="Books">Personal Hygiene</option>
                            <option value="Clothes">Clothing & Footwear</option>
                            <option value="Electronics">Bedding & Linens</option>
                            <option value="Furniture">Health & Wellness</option>
                            <option value="Household Items">School Supplies</option>
                            <option value="Toys">Technology for Learning</option>
                            <option value="Food">Food Items</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <!-- Input field for Others category -->
                    <div id="otherCategoryInput" style="display: none;">
                        <label class="block text-sm font-medium text-black mb-2">Specify Other Category</label>
                        <input type="text" name="other_category" id="otherCategoryField" class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent" placeholder="Enter other category">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Item Condition</label>
                        <select name="condition" required class="w-full px-4 py-2.5 bg-white border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                            <option value="">Select Condition</option>
                            <option value="New">New</option>
                            <option value="Like New">Like New</option>
                            <option value="Good">Good</option>
                        </select>
                    </div>
                    <!-- Quantity Field (always visible after Item Condition) -->
                    <div id="quantityField">
                        <label class="block text-sm font-medium text-black mb-2">Quantity</label>
                        <input type="text" name="quantity" id="quantityInput" placeholder="Enter quantity" class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Name</label>
                        <input type="text" name="donor_name" placeholder="Full Name" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Email</label>
                        <input type="email" name="donor_email" placeholder="you@email.com" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Contact Number</label>
                        <input type="tel" name="donor_phone" placeholder="Your contact number" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent" inputmode="numeric" maxlength="13">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Drop-off Location</label>
                        <div class="bg-[#B7E4FA] p-4 rounded-lg">
                            <p class="text-black font-medium">Carlock Street, San Nicolas Proper</p>
                            <p class="text-black">6000 Cebu City, Philippines</p>
                            <p class="text-sm text-black mt-2">Please bring your donation to this address during your preferred drop-off time.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Upload Image</label>
                        <div class="border-2 border-dashed border-[#0A90A4] rounded-lg p-6 text-center cursor-pointer hover:border-[#0A90A4] transition-colors" onclick="document.getElementById('uploadInput').click()">
                            <div id="uploadText" class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-[#0A90A4]" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="text-[#0A90A4] font-medium">Browse files</div>
                                <div class="text-xs text-[#0A90A4]">Please upload the actual photo of the item to donate</div>
                            </div>
                            <input type="file" id="uploadInput" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                            <img id="preview" class="mx-auto max-h-32 hidden">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Preferred Drop-off Time</label>
                        <input type="datetime-local" name="expected_date" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Note</label>
                        <textarea name="description" rows="4" placeholder="Please describe the item you wish to donate..." required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent"></textarea>
                    </div>
                </div>

                <!-- Important Information -->     
                <div class="md:col-span-2 bg-[#B7E4FA] p-4 rounded-lg border-l-4 border-[#0A90A4]">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-[#0A90A4] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-black">Important Information</p>
                            <ul class="mt-1 text-sm text-black list-disc list-inside">
                                <li>Please ensure your item is in good condition and properly cleaned before donation.</li>
                                <li>Our team will review your submission and contact you within 24-48 hours to confirm the drop-off arrangement.</li>
                                <p class="text-sm font-semibold text-black">For Health & Wellness items:</p>
                                <li>All over-the-counter medications must have at least 6 months remaining before their expiry date.</li>
                                <li>Ensure that items are sealed and in their original packaging.</li>
                                <li>All donations must be properly packaged and labeled.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Validation Errors -->
                @if($errors->any())
                <div class="md:col-span-2 bg-red-50 p-4 rounded-lg border-l-4 border-red-600">
                    <div class="flex items-start">
                        <svg class="h-6 w-6 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm font-semibold text-red-900">Please correct the following errors:</p>
                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Buttons -->
                <div class="md:col-span-2 flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="window.location.href='/'" class="px-6 py-2.5 bg-white text-[#0A90A4] border border-[#0A90A4] rounded-lg hover:bg-[#B7E4FA] hover:text-[#0A90A4] transition-colors font-medium">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#0A90A4] text-white rounded-lg hover:bg-[#0A90A4] transition-colors font-medium">Submit Donation</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-[#e6f4ea] text-gray-800 py-10 px-6 mt-12 animate-fade-in">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Hauz Hayag Scholarship</h2>
                    <p class="text-sm leading-relaxed">
                        Supporting education through scholarship and nourishment. Hauz Hayag believes in empowering the youth for a brighter future.
                    </p>
                </div>
         
                <!-- Quick Links -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Quick Links</h2>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="hover:underline">Home</a></li>
                        <li><a href="#scholarships" class="hover:underline">Programs</a></li>
                        <li><a href="#about-us" class="hover:underline">About Us</a></li>
                        <li><button class="hover:underline text-left" onclick="handleLoginClick()">Login</button></li>
                    </ul>
                </div>
         
                <!-- Contact Info -->
                <div>
                    <h2 class="text-lg font-semibold mb-4">Contact Us</h2>
                    <p class="text-sm">📍 Carlock Street, San Nicolas Proper, Cebu City, Philippines</p>
                    <p class="text-sm">📧 hauzhayag143@gmail.com</p>
                    <p class="text-sm">📞 (032) 384 6594</p>
                    <p class="text-sm">🌐 hayag-project.com</p>
                </div>
            </div>
         
            <div class="border-t mt-10 pt-4 text-center text-sm text-gray-500">
                &copy; 2025 Hauz Hayag Scholarship. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Donation Option Modal -->
    <div id="donationOptionsModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Choose Your Donation Preference</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        How would you like to donate?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="donateAnonymouslyBtn" class="px-4 py-2 bg-[#0A90A4] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#098a9d] focus:outline-none focus:ring-2 focus:ring-[#0A90A4] transition-colors">
                        Donate Anonymously
                    </button>
                    <button id="beAcknowledgedBtn" class="mt-3 px-4 py-2 bg-[#0A90A4] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#098a9d] focus:outline-none focus:ring-2 focus:ring-[#0A90A4] transition-colors">
                        Be Acknowledged
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Thank You Modal -->
    <div id="thankYouModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-[#0A90A4] mb-4">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Thank You!</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Your donation has been received. We appreciate your generosity and support.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <a href="{{ route('donation') }}" class="px-4 py-2 bg-[#0A90A4] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#098a9d] focus:outline-none focus:ring-2 focus:ring-[#0A90A4] transition-colors">
                        Back to Donation Page
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to preview image (already exists in your file, keep it or merge)
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            const uploadText = document.getElementById('uploadText');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    uploadText.classList.add('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        // Get the modal elements
        const donationOptionsModal = document.getElementById('donationOptionsModal');
        const thankYouModal = document.getElementById('thankYouModal');
        const donationForm = document.getElementById('donationForm');
        const donationPreferenceInput = document.createElement('input'); // Create hidden input dynamically
        donationPreferenceInput.type = 'hidden';
        donationPreferenceInput.name = 'donation_preference';
        donationForm.appendChild(donationPreferenceInput); // Append to form


        // Intercept form submission
        donationForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Show the donation options modal
            donationOptionsModal.classList.remove('hidden');
        });

        // Handle donation preference selection (Anonymous)
        document.getElementById('donateAnonymouslyBtn').addEventListener('click', function() {
            donationPreferenceInput.value = 'anonymous';
            donationOptionsModal.classList.add('hidden'); // Hide options modal

            submitForm(); // Submit the form
        });

        // Handle donation preference selection (Acknowledged)
        document.getElementById('beAcknowledgedBtn').addEventListener('click', function() {
            donationPreferenceInput.value = 'acknowledged';
            donationOptionsModal.classList.add('hidden'); // Hide options modal

            submitForm(); // Submit the form
        });

        // Function to validate Philippine contact numbers
        function validatePhilippineContactNumber(phoneNumber) {
            // Regex for 09xxxxxxxx format (11 digits total)
            const localRegex = /^09\d{9}$/;
            // Regex for +639xxxxxxxx format (13 characters including +)
            const internationalRegex = /^\+639\d{9}$/;

            if (localRegex.test(phoneNumber) || internationalRegex.test(phoneNumber)) {
                return { valid: true };
            } else {
                return { valid: false, error: "Invalid Philippine mobile number format. Please use 09xxxxxxxx or +639xxxxxxxx." };
            }
        }

        // Function to submit the form via fetch
        function submitForm() {
            console.log('Attempting to submit non-monetary donation form.');
            const donationForm = document.getElementById('donationForm');
            const formData = new FormData(donationForm);
            const contactNumberInput = donationForm.querySelector('input[name="donor_phone"]');
            const contactNumber = contactNumberInput.value.trim();

            // Validate contact number
            const validationResult = validatePhilippineContactNumber(contactNumber);
            if (!validationResult.valid) {
                alert(validationResult.error);
                contactNumberInput.focus(); // Focus the input field
                return; // Stop submission
            }

            // Check if 'Others' category is selected and update the category in formData
            const categorySelect = document.getElementById('category');
            const otherCategoryField = document.getElementById('otherCategoryField');

            if (categorySelect.value === 'Others') {
                const otherCategory = otherCategoryField.value.trim();
                if (otherCategory) {
                    formData.set('category', otherCategory); // Set the category in FormData to the specified value
                } else {
                     // Handle case where Others is selected but field is empty (should be prevented by 'required' but good to double check)
                     alert('Please specify the other category.');
                     donationOptionsModal.classList.add('hidden'); // Hide modal if open
                     return; // Stop submission
                }
            } else {
                // If a predefined category is selected, ensure the other_category is not sent
                formData.delete('other_category');
            }

            fetch(donationForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json()) // Assuming your backend returns JSON
            .then(data => {
                if (data.success) {
                    document.getElementById('thankYouModal').classList.remove('hidden');
                } else {
                    console.error('Error:', data.message || 'Unknown error', data.errors);
                    let errorMessage = 'There was an error submitting your donation.';
                    if (data.message) {
                        errorMessage += ': ' + data.message;
                    } else if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat();
                        if (errorMessages.length > 0) {
                            errorMessage += ' Validation failed:\n' + errorMessages.join('\n');
                        }
                    }
                    alert(errorMessage + ' Please check the console for details.');
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('Submission failed: ' + (error.message || 'An unknown error occurred. Please check the console for details.'));
            });
        }

         // Optional: Add a way to close the modals if needed (e.g., clicking outside or a close button)
         // For simplicity, we are only showing the thank you modal on success and linking back to donation page.
         // If you need close buttons on the modals, you'll need to add them to the HTML and add corresponding JS.

        // Remove the old modal logic and replace with simple input field logic
        document.getElementById('category').addEventListener('change', function() {
            const otherCategoryInput = document.getElementById('otherCategoryInput');
            const otherCategoryField = document.getElementById('otherCategoryField');
            
            if (this.value === 'Others') {
                otherCategoryInput.style.display = 'block';
                otherCategoryField.setAttribute('required', 'true');
            } else {
                otherCategoryInput.style.display = 'none';
                otherCategoryField.removeAttribute('required');
                otherCategoryField.value = '';
            }
        });

        // Restrict contact number input to digits and an optional leading + and limit length
        document.getElementById('donationForm').querySelector('input[name="donor_phone"]').addEventListener('input', function (e) {
            let value = e.target.value;

            // Remove all non-digits, but allow a leading '+'
            let cleanedValue = '';
            if (value.startsWith('+')) {
                cleanedValue = '+' + value.substring(1).replace(/[^0-9]/g, '');
            } else {
                cleanedValue = value.replace(/[^0-9]/g, '');
            }

            // Apply strict length limit based on leading character
            let limitedValue = cleanedValue;
            if (limitedValue.startsWith('+')) {
                 if (limitedValue.length > 13) {
                    limitedValue = limitedValue.substring(0, 13);
                 }
            } else { // Assuming anything else starting with a digit should follow the 09... pattern length
                 if (limitedValue.length > 11) {
                    limitedValue = limitedValue.substring(0, 11);
                 }
            }

            e.target.value = limitedValue;
        });

    </script>
</body>
</html>