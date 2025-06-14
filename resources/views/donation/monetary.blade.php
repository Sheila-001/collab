<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monetary Donation</title>
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
    
    <div class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-4xl p-8 relative">
            <!-- Close Button -->
            <button onclick="window.location.href='/'" class="absolute right-6 top-6 text-[#0A90A4] hover:text-[#0A90A4]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <h2 class="text-2xl md:text-3xl font-bold text-black text-center mb-2">Monetary Donation</h2>
            <p class="text-lg text-black text-center mb-8">Your generosity makes a difference</p>
            
            <form id="donationForm" action="{{ route('monetary_donation.submit') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf

                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Donation Method</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="bank-transfer" name="payment_method" type="radio" value="bank_transfer" checked class="h-4 w-4 text-[#0A90A4] focus:ring-[#0A90A4] border-[#0A90A4]">
                                <label for="bank-transfer" class="ml-3 block text-sm font-medium text-black">Bank Transfer</label>
                            </div>
                            <div class="flex items-center">
                                <input id="gcash" name="payment_method" type="radio" value="gcash" class="h-4 w-4 text-[#0A90A4] focus:ring-[#0A90A4] border-[#0A90A4]">
                                <label for="gcash" class="ml-3 block text-sm font-medium text-black">GCash</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer QR (shown by default) -->
                    <div id="bankDetails" class="space-y-4 bg-[#B7E4FA] p-4 rounded-lg flex flex-col items-center">
                        <h3 class="text-sm font-semibold text-black mb-2">Bank Transfer QR Code</h3>
                        <img src="{{ asset('image/HauzBank.jpg.jpg') }}" alt="Bank Transfer QR Code" class="mx-auto max-w-xs max-h-80 rounded shadow border-4 border-[#0A90A4]">
                        <p class="text-center text-black mt-2 text-sm font-medium">Scan this QR code with your banking app.</p>
                    </div>

                    <!-- GCash QR (hidden by default) -->
                    <div id="gcashDetails" class="space-y-4 bg-[#B7E4FA] p-4 rounded-lg hidden flex flex-col items-center">
                        <h3 class="text-sm font-semibold text-black mb-2">GCash QR Code</h3>
                        <div class="bg-white p-2 rounded shadow border-4 border-[#0A90A4] flex justify-center items-center">
                            <img src="{{ asset('image/HauzGcash.jpg.jpg') }}" alt="GCash QR Code" class="max-w-xs max-h-80 object-contain">
                        </div>
                        <p class="text-center text-black mt-2 text-sm font-medium">Scan this QR code with your GCash app.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Amount (PHP)</label>
                        <input type="number" name="amount" placeholder="Enter amount" min="1" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Name</label>
                        <input type="text" name="donor_name" placeholder="Full Name" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Email</label>
                        <input type="email" name="donor_email" placeholder="you@email.com" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Contact Number</label>
                        <input type="tel" name="donor_phone" placeholder="Your contact number" required class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent" inputmode="numeric" pattern="[0-9]*">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Proof of Donation</label>
                        <div class="border-2 border-dashed border-[#0A90A4] rounded-lg p-6 text-center cursor-pointer hover:border-[#0A90A4] transition-colors" onclick="document.getElementById('proofUpload').click()">
                            <div id="proofUploadText" class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-[#0A90A4]" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="text-[#0A90A4] font-medium">Browse Files</div>
                                <div class="text-xs text-[#0A90A4]">(Screenshot or photo of transaction receipt)</div>
                            </div>
                            <input type="file" id="proofUpload" name="proof" accept="image/*,.pdf" class="hidden" onchange="previewProof(event)">
                            <div id="proofPreview" class="hidden mt-4">
                                <img id="proofImagePreview" class="mx-auto max-h-40 object-contain" src="#" alt="Proof of Donation Preview">
                                <p class="text-sm font-medium text-black mt-2">Selected file:</p>
                                <p id="proofFilename" class="text-sm text-[#0A90A4]"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-black mb-2">Note (Optional)</label>
                        <textarea name="message" rows="3" placeholder="Any additional note..." class="w-full px-4 py-2.5 border border-[#0A90A4] rounded-lg focus:ring-2 focus:ring-[#0A90A4] focus:border-transparent"></textarea>
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
                            <p class="mt-1 text-sm text-black">
                                Your donation will be processed within 24 hours. Please ensure your proof of payment is clear and shows the transaction details. 
                                You will receive a confirmation email once your donation is verified. For any questions, please contact <span class="underline text-[#0A90A4]">donations@charity.org</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="window.location.href='{{ route('welcome') }}'" class="px-6 py-2.5 bg-white text-[#0A90A4] border border-[#0A90A4] rounded-lg hover:bg-[#B7E4FA] hover:text-[#0A90A4] transition-colors font-medium">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#0A90A4] text-white rounded-lg hover:bg-[#0A90A4] transition-colors font-medium">Submit Donation</button>
                </div>
                <input type="hidden" name="campaign_id" id="campaignIdInput">
                <input type="hidden" name="donation_preference" id="donationPreferenceInput" value="anonymous">
            </form>
        </div>
    </div>

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
                    <a href="{{ route('welcome') }}" class="px-4 py-2 bg-[#0A90A4] text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-[#098a9d] focus:outline-none focus:ring-2 focus:ring-[#0A90A4] transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get campaign_id from URL query parameters
        const urlParams = new URLSearchParams(window.location.search);
        const campaignId = urlParams.get('campaign_id');
        if (campaignId) {
            document.getElementById('campaignIdInput').value = campaignId;
        }

        // Toggle between bank and GCash details
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'bank_transfer') {
                    document.getElementById('bankDetails').classList.remove('hidden');
                    document.getElementById('gcashDetails').classList.add('hidden');
                } else {
                    document.getElementById('bankDetails').classList.add('hidden');
                    document.getElementById('gcashDetails').classList.remove('hidden');
                }
            });
        });

        function previewProof(event) {
            const input = event.target;
            const proofPreview = document.getElementById('proofPreview');
            const proofUploadText = document.getElementById('proofUploadText');
            const proofFilename = document.getElementById('proofFilename');
            const proofImagePreview = document.getElementById('proofImagePreview');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (file.size > maxSize) {
                    alert('File size must be less than 2MB');
                    input.value = '';
                    proofImagePreview.classList.add('hidden');
                    proofPreview.classList.add('hidden');
                    proofUploadText.classList.remove('hidden');
                    return;
                }

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        proofImagePreview.src = e.target.result;
                        proofImagePreview.classList.remove('hidden');
                        proofUploadText.classList.add('hidden');
                        proofPreview.classList.remove('hidden');
                    }

                    reader.readAsDataURL(file);
                } else {
                    proofImagePreview.classList.add('hidden');
                    proofUploadText.classList.add('hidden');
                    proofPreview.classList.remove('hidden');
                }

                proofFilename.textContent = file.name;

            } else {
                proofImagePreview.src = '#';
                proofImagePreview.classList.add('hidden');
                proofPreview.classList.add('hidden');
                proofUploadText.classList.remove('hidden');
                proofFilename.textContent = '';
            }
        }

        // Philippine Contact Number Validation Function
        function validatePhilippineContactNumber(number) {
            // Regex for Philippine mobile numbers (e.g., 09XX-XXX-XXXX, +639XX-XXX-XXXX)
            const mobileRegex = /^(09|\+639)\d{9}$/;
            // Regex for Philippine landline numbers (e.g., (0X) XXX-XXXX, +63X-XXX-XXXX)
            const landlineRegex = /^(0\d{1,2}|\+63\d{1,2})\d{6,8}$/;

            if (mobileRegex.test(number) || landlineRegex.test(number)) {
                return { valid: true, error: null };
            } else {
                return { valid: false, error: 'Please enter a valid Philippine contact number (e.g., 09xx-xxxxxxx, +639xx-xxxxxxx, or a landline number).' };
            }
        }

        let submittedDonationId = null; // Declare it in a higher scope

        // Form submission
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const contactNumberInput = document.getElementById('donationForm').querySelector('input[name="donor_phone"]');
            const contactNumber = contactNumberInput.value.trim();

            // Validate contact number
            const validationResult = validatePhilippineContactNumber(contactNumber);
            if (!validationResult.valid) {
                alert(validationResult.error);
                contactNumberInput.focus(); // Focus the input field
                return; // Stop submission
            }

            const form = e.target;
            const formData = new FormData(form);
            // submittedDonationId is already declared above

            // First, submit the donation data
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        console.error('Backend Error Response (Initial Donation):', errorData);
                        if (errorData.message) {
                             throw new Error(errorData.message);
                        } else if (errorData.errors) {
                            const errorMessages = Object.values(errorData.errors).flat();
                            throw new Error('Validation failed:\\n' + errorMessages.join('\\n'));
                        } else {
                            throw new Error('Something went wrong on the server.');
                        }
                    }).catch(() => {
                        throw new Error('Server error: ' + response.status + ' ' + response.statusText);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    submittedDonationId = data.donation_id;
                    // Show the donation options modal
                    document.getElementById('donationOptionsModal').classList.remove('hidden');
                } else {
                    console.error('Error (Initial Donation):', data.message || 'Unknown error', data.errors);
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
                console.error('Fetch Error (Initial Donation):', error);
                alert('Submission failed: ' + (error.message || 'An unknown error occurred. Please check the console for details.'));
            });
        });

        // Handle donation preference selection
        document.getElementById('donateAnonymouslyBtn').addEventListener('click', function() {
            updatePreference('anonymous', submittedDonationId);
        });

        document.getElementById('beAcknowledgedBtn').addEventListener('click', function() {
            updatePreference('acknowledged', submittedDonationId);
        });

        function updatePreference(preference, donationId) {
            if (!donationId) {
                console.error('Donation ID is missing for preference update.');
                alert('Error: Cannot update donation preference. Donation ID is missing.');
                return;
            }

            // Make an AJAX call to update the donation preference
            fetch(`/api/donations/${donationId}/preference`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ donation_preference: preference })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        console.error('Backend Error Response (Preference Update):', errorData);
                        throw new Error(errorData.message || 'Failed to update preference on the server.');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('donationOptionsModal').classList.add('hidden');
                    document.getElementById('thankYouModal').classList.remove('hidden');
                } else {
                    console.error('Error (Preference Update):', data.message || 'Unknown error');
                    alert('Failed to update donation preference: ' + (data.message || 'An unknown error occurred.'));
                }
            })
            .catch(error => {
                console.error('Fetch Error (Preference Update):', error);
                alert('Failed to update donation preference: ' + (error.message || 'An unknown error occurred. Please check console.'));
            });
        }

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