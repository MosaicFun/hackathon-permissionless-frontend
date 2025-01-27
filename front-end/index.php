<?php
// get walletAddress from url
$walletAddress = $_GET['walletAddress'];
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <link rel="icon"
        type="image/png"
        href="img/favicon.png" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://kit.fontawesome.com/77adf10444.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.6.4/dist/full.css" rel="stylesheet" type="text/css"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.7.4-rc.1/web3.min.js"></script>
  <script>

      // document.addEventListener("DOMContentLoaded", function() {
      //     // This block of code will run after the page is fully loaded
      //     document.getElementById("walletAddressForm").addEventListener("submit", function(event) {
      //         event.preventDefault();
      //         const walletAddress = document.getElementById("walletAddress").value;
      //         console.log("Entered wallet address:", walletAddress);
      //         // convert walletAddress into string
      //
      //     });
      // });


      /* To connect using MetaMask */
      async function connect() {
          if (window.ethereum) {

              // Assuming you're within an async function or an environment that supports 'await'
              await window.ethereum.request({method: "eth_requestAccounts"});
              window.web3 = new Web3(window.ethereum);
              const accounts = await window.web3.eth.getAccounts();
              const account = accounts[0];
              document.getElementById("account").innerHTML = "Your address is: " + account;
              console.log(account);


              // Make a POST request to the Gitcoin Scorer API
              fetch('https://api.scorer.gitcoin.co/registry/submit-passport', {
                  method: 'POST',
                  headers: {
                      'Accept': 'application/json',
                      'X-API-Key': 'TNEGHQEp.vsTwO4RyQrl24yzxMPst8qEoGDjKhMCU',
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                      address: account,
                      scorer_id: '5774'
                  })
              })
                  .then(response => response.json())
                  .then(data => {
                      const addressScore = data.score !== undefined ? data.score : 0;
                      document.getElementById("score").innerHTML = "Your score is: " + addressScore;

                      // Existing code to update scoreIndicator
                      if (addressScore >= 20) {
                          document.getElementById("scoreIndicator").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Score 20 or above';

                          // Add the button to the claimButtonContainer
                          document.getElementById("claimButtonContainer").innerHTML = `
                            <button id="claimButton"
                                class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                              Claim
                            </button>
                          `;

                          document.getElementById("claimButton").addEventListener("click", function () {
                              // Show "Thank you for minting" message
                              alert("Thank you for minting");
                          });

                          // Add event listener to the button
                          document.getElementById("claimButton").addEventListener("click", function () {
                              // Perform GET request to your localhost URL
                              fetch(`http://localhost:8080/mintnft?classSymbol=REGEN1&nftID=NFT0001&recipientAddress=<?php echo $walletAddress ?>`)
                                  .then(response => response.json())
                                  .then(data => {
                                      // Handle the response data here
                                      console.log('Mint NFT Response:', data);
                                  })
                                  .catch(error => {
                                      console.error('Mint NFT Error:', error);
                                  });
                          });

                      } else {
                          document.getElementById("scoreIndicator").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Below 20';
                          document.getElementById("claimButtonContainer").innerHTML = '';  // Remove the button
                      }

                      console.log('Address Score:', addressScore);
                  })
                  .catch(error => {
                      console.error('Error:', error);
                  });

              // get providers
              // Fetch data from Gitcoin Scorer API
              // Dynamic URL with the Ethereum address
              async function connect() {
                  // Initialize an empty array to hold providers
                  let providers = [];

                  try {
                      await window.ethereum.request({method: "eth_requestAccounts"});
                      window.web3 = new Web3(window.ethereum);
                      const accounts = await window.web3.eth.getAccounts();
                      const account = accounts[0]; // Ethereum address collected from wallet
                      document.getElementById("account").innerHTML = "Your address is: " + account;

                      // Dynamic URL with the Ethereum address
                      const url = `https://api.scorer.gitcoin.co/registry/stamps/${account}?limit=1000&include_metadata=false`;

                      const response = await fetch(url, {
                          method: 'GET',
                          headers: {
                              'Accept': 'application/json',
                              'X-API-Key': 'TNEGHQEp.vsTwO4RyQrl24yzxMPst8qEoGDjKhMCU'
                          }
                      });

                      const data = await response.json();

                      // Populate the providers array
                      providers = data.items.map(item => item.credential.credentialSubject.provider);
                      console.log(providers);
                      // Check if 'providers' contains "Facebook"
                      if (providers.includes("Facebook")) {
                          const socialScore = true;

                          document.getElementById("facebookStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Facebook';
                      } else {
                          document.getElementById("facebookStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Facebook';
                      }

                      if (providers.includes("Linkedin")) {
                          const socialScore = true;

                          document.getElementById("linkedinStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Linkedin';
                      } else {
                          document.getElementById("linkedinStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Linkedin';
                      }

                      if (providers.includes("Google")) {
                          const socialScore = true;

                          document.getElementById("googleStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Google';
                      } else {
                          document.getElementById("googleStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Google';
                      }


                      // Define the list of GitHub-related provider strings to check for
                      const githubCheckList = [
                          "githubContributionActivityGte#120",
                          "githubContributionActivityGte#60",
                          "githubContributionActivityGte#30",
                          "githubAccountCreationGte#365",
                          "githubAccountCreationGte#180",
                          "githubAccountCreationGte#90"
                      ];

                      // Check if 'providers' contains any of the specified GitHub-related strings
                      const hasGithubStatus = githubCheckList.some(item => providers.includes(item));

                      // Update the githubStatus element based on the check result
                      if (hasGithubStatus) {
                          const socialScore = true;

                          document.getElementById("githubStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> GitHub Status';
                      } else {
                          document.getElementById("githubStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> GitHub Status';
                      }

                      // Define the list of Twitter-related provider strings to check for
                      const twitterCheckList = [
                          "twitterAccountAgeGte#730",
                          "twitterAccountAgeGte#365",
                          "twitterAccountAgeGte#180"
                      ];

                      // Check if 'providers' contains any of the specified Twitter-related strings
                      const hasTwitterStatus = twitterCheckList.some(item => providers.includes(item));

                      // Update the twitterStatus element based on the check result
                      if (hasTwitterStatus) {
                          const socialScore = true;
                          if (socialScore === true) {
                              // Show a new claim button in a container with the ID claimButtonContainer2
                              document.getElementById("claimButtonContainer2").innerHTML = `
    <button id="newClaimButton"
      class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
      Claim
    </button>
  `;

                              // Add an event listener to the new button
                              document.getElementById("newClaimButton").addEventListener("click", function () {
                                  // Your code to handle the new claim button click, e.g., minting the NFT
                                  // ...

                                  // Optionally show a "Thank you for minting" message
                                  alert("Thank you for the new claim.");
                              });
                          } else {
                              // Show a "Not Eligible" button in a container with the ID claimButtonContainer2
                              document.getElementById("claimButtonContainer2").innerHTML = `
    <button id="notEligibleButton"
      class="rounded-md bg-gray-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm">
      Not Eligible
    </button>
  `;

                              // Add an event listener to the "Not Eligible" button
                              document.getElementById("notEligibleButton").addEventListener("click", function () {
                                  // Your code to handle the "Not Eligible" button click
                                  // ...

                                  // Optionally show a message
                                  alert("You are not eligible for the new claim.");
                              });
                          }
                          document.getElementById("twitterStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Twitter Status';
                      } else {
                          document.getElementById("twitterStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Twitter Status';
                      }



                      // Check for the specific Gitcoin contributor statistic strings
                      const hasGitcoinContribution = providers.includes("GitcoinContributorStatistics#numGr14ContributionsGte#1");
                      const hasGitcoinGrantsContribution = providers.includes("GitcoinContributorStatistics#numGrantsContributeToGte#1");
                      const hasGitcoinRoundsContribution = providers.includes("GitcoinContributorStatistics#numRoundsContributedToGte#1");
                      const hasGitcoinTotalContributionAmount = providers.includes("GitcoinContributorStatistics#totalContributionAmountGte#10");

// Update the gitcoinContributionStatus element
                      if (hasGitcoinContribution) {
                          document.getElementById("gitcoinContributionStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Gitcoin Contributions';
                      } else {
                          document.getElementById("gitcoinContributionStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Gitcoin Contributions';
                      }

// Update the gitcoinGrantsContributionStatus element
                      if (hasGitcoinGrantsContribution) {
                          document.getElementById("gitcoinGrantsContributionStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Gitcoin Grants';
                      } else {
                          document.getElementById("gitcoinGrantsContributionStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Gitcoin Grants';
                      }

// Update the gitcoinRoundsContributionStatus element
                      if (hasGitcoinRoundsContribution) {
                          document.getElementById("gitcoinRoundsContributionStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Gitcoin Rounds';
                      } else {
                          document.getElementById("gitcoinRoundsContributionStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Gitcoin Rounds';
                      }

// Update the gitcoinTotalContributionAmountStatus element
                      if (hasGitcoinTotalContributionAmount) {
                          document.getElementById("gitcoinTotalContributionAmountStatus").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Gitcoin Total Contribution';
                      } else {
                          document.getElementById("gitcoinTotalContributionAmountStatus").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Gitcoin Total Contribution';
                      }

                  } catch (error) {
                      console.error('Error:', error);
                  }
              }

              // Execute the connect function
              connect();

          } else {
              console.log("No wallet");
          }
      }
  </script>
  <title>Regen Score</title>
</head>
<body>


<div class="bg-white">
  <!-- Header -->
  <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
    <div class="grid grid-cols-12 gap-5">
      <div class="col-span-12 text-black">
        <h1 class="font-bold tracking-tight text-gray-900 text-6xl">RegenScore</h1>
      </div>
    </div>
  </div>

  <main class="isolate">
    <!-- Hero section -->
    <div class="relative isolate -z-10">
      <svg
          class="absolute inset-x-0 top-0 -z-10 h-[64rem] w-full stroke-gray-200 [mask-image:radial-gradient(32rem_32rem_at_center,white,transparent)]"
          aria-hidden="true">
        <defs>
          <pattern id="1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84" width="200" height="200" x="50%" y="-1"
                   patternUnits="userSpaceOnUse">
            <path d="M.5 200V.5H200" fill="none"/>
          </pattern>
        </defs>
        <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
          <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z"
                stroke-width="0"/>
        </svg>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#1f932ae7-37de-4c0a-a8b0-a6e3b4d44b84)"/>
      </svg>
      <div class="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48"
           aria-hidden="true">
        <div class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
             style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)"></div>
      </div>
      <div class="overflow-hidden">
        <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
          <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
            <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl text-center">
              <h2 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Airdrops for people who create
                value</h2>
              <p class="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">RegenScore is a
                platform where regens can earn airdrops for creating value. We aggregate open data, measure regen
                activity, and create incentives for people to level up and unlock crypto rewards.</p>
            </div>
            <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
              <div
                  class="ml-auto w-44 flex-none space-y-8 pt-32 sm:ml-0 sm:pt-80 lg:order-last lg:pt-36 xl:order-none xl:pt-80">
                <div class="relative">

                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
              <div class="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-52 lg:pt-36">
                <div class="relative">

                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="relative">
                  <img
                      src="img/regenscore-stamp-drop.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
              <div class="w-44 flex-none space-y-8 pt-32 sm:pt-0">
                <div class="relative">
                  <img
                      src="img/regenscore-social-drop.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="relative">
                  <img
                      src="img/regenscore-funding-drop.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
      <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 text-black">

          <h2 class="text-3xl font-bold pb-3">Connect your wallet to see if your eligible</h2>

          <!-- Display a connect button and the current account -->
          <input type="button"
                 class="rounded-md bg-orange-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                 value="Connect Wallet" onclick="connect();">
          <div id="score" class="pt-2">
          </div>
          <div id="account">

          </div>


        </div>
        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Social checklist</h2>
          <span>Minimum amount 1</span>
          <ul class="list-none pt-3">
            <li id="facebookStatus">Facebook</li>
            <li id="linkedinStatus">Linkedin</li>
            <li id="githubStatus">Github</li>
            <li id="googleStatus">Google</li>
            <li id="twitterStatus">Twitter</li>
          </ul>
        </div>
        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Passport Score</h2>
          <ul class="list-none pt-3">
            <li class="" id="scoreIndicator">Score 20 or above</li>
          </ul>
        </div>

        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Gitcoin Grants</h2>
          <span>Minimum amount 1</span>
          <ul class="list-none pt-3">
            <li id="gitcoinContributionStatus">Gitcoin Contributions</li>
            <li id="gitcoinGrantsContributionStatus">Gitcoin Grants</li>
            <li id="gitcoinRoundsContributionStatus">Gitcoin Rounds</li>
            <li id="gitcoinTotalContributionAmountStatus">Gitcoin Total Contribution</li>

          </ul>
        </div>
      </div>
    </div>

    <!-- Image section -->
    <div class="pt-10 xl:mx-auto xl:max-w-7xl xl:px-8 ">
      <div class="grid grid-cols-3  gap-5">

        <div class="col px-2">
          <img
              src="img/regenscore-social-drop.png"
              alt="" class="w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2" id="claimButtonContainer">
            Connect your wallet to see if your eligible
          </div>
        </div>
        <div class="col px-2">
          <img
              src="img/regenscore-stamp-drop.png"
              alt="" class="w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2" id="claimButtonContainer2">
            Connect your wallet to see if your eligible
          </div>
        </div>


        <div class="col px-2">
          <img
              src="img/regenscore-funding-drop.png"
              alt="" class="w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2"  id="gitcoinTotalContributionAmountStatus">
            Connect your wallet to see if your eligible

          </div>
        </div>
      </div>
    </div>

    <footer class="py-5">
      <p class="mt-10 text-center text-xs leading-5 text-gray-500"> Mosaic Labs, Inc. &copy; All Rights Reserved 2023</p>
    </footer>
  </main>
</div>


</body>
</html>