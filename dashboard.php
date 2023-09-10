<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://kit.fontawesome.com/77adf10444.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.6.4/dist/full.css" rel="stylesheet" type="text/css"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/1.7.4-rc.1/web3.min.js"></script>
  <script>
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
                      'X-API-Key': 'api key',
                      'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({
                      address: account,
                      scorer_id: '5774'
                  })
              })
                  .then(response => response.json())
                  .then(data => {
                      const addressScore = data.score;
                      document.getElementById("score").innerHTML = "Your score is: " + addressScore;

                      // Use getElementById and if statement to display the score status
                      if (addressScore >= 20) {
                          document.getElementById("scoreIndicator").innerHTML = '<i class="fa-duotone fa-check text-green-500"></i> Score 20 or above';
                      } else {
                          document.getElementById("scoreIndicator").innerHTML = '<i class="fa-duotone fa-x text-red-500"></i> Below 20';
                      }

                      console.log('Address Score:', addressScore);
                  })
                  .catch(error => {
                      console.error('Error:', error);
                  });

          } else {
              console.log("No wallet");
          }
      }
  </script>
  <title>Data Dashboard</title>
</head>
<body>


<div class="bg-white">
  <!-- Header -->


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
            <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
              <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Wire some amazing text here.</h1>
              <p class="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">Cupidatat minim id
                magna ipsum sint dolor qui. Sunt sit in quis cupidatat mollit aute velit. Et labore commodo nulla aliqua
                proident mollit ullamco exercitation tempor. Sint aliqua anim nulla sunt mollit id pariatur in voluptate
                cillum. Eu voluptate tempor esse minim amet fugiat veniam occaecat aliqua.</p>
            </div>
            <div class="mt-14 flex justify-end gap-8 sm:-mt-44 sm:justify-start sm:pl-20 lg:mt-0 lg:pl-0">
              <div
                  class="ml-auto w-44 flex-none space-y-8 pt-32 sm:ml-0 sm:pt-80 lg:order-last lg:pt-36 xl:order-none xl:pt-80">
                <div class="relative">
                  <img
                      src="img/buildspaces4w2_.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
              <div class="mr-auto w-44 flex-none space-y-8 sm:mr-0 sm:pt-52 lg:pt-36">
                <div class="relative">
                  <img
                      src="img/buildspaces4w2_.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="relative">
                  <img
                      src="img/buildspaces4w2_.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
              <div class="w-44 flex-none space-y-8 pt-32 sm:pt-0">
                <div class="relative">
                  <img
                      src="img/buildspaces4w2_.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
                <div class="relative">
                  <img
                      src="img/buildspaces4w2_.png"
                      alt="" class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg">
                  <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Content section -->
    <div class="mx-auto -mt-12 max-w-7xl px-6 sm:mt-0 lg:px-8 xl:-mt-8">
      <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Describe the qualifications for the
          airdrop</h2>
        <div class="mt-6 flex flex-col gap-x-8 gap-y-20 lg:flex-row">
          <div class="lg:w-full lg:max-w-2xl lg:flex-auto">
            <p class="text-xl leading-8 text-gray-600">Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem.
              At arcu, sit dui mi, nibh dui, diam eget aliquam. Quisque id at vitae feugiat egestas ac. Diam nulla orci
              at in viverra scelerisque eget. Eleifend egestas fringilla sapien.</p>
            <div class="mt-10 max-w-xl text-base leading-7 text-gray-700">
              <p>Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris semper sed amet
                vitae sed turpis id. Id dolor praesent donec est. Odio penatibus risus viverra tellus varius sit neque
                erat velit. Faucibus commodo massa rhoncus, volutpat. Dignissim sed eget risus enim. Mattis mauris
                semper sed amet vitae sed turpis id.</p>
              <p class="mt-10">Et vitae blandit facilisi magna lacus commodo. Vitae sapien duis odio id et. Id blandit
                molestie auctor fermentum dignissim. Lacus diam tincidunt ac cursus in vel. Mauris varius vulputate et
                ultrices hac adipiscing egestas. Iaculis convallis ac tempor et ut. Ac lorem vel integer orci.</p>
            </div>
          </div>
          <div class="lg:flex lg:flex-auto lg:justify-center">
            <dl class="w-64 space-y-8 xl:w-80">
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">Something</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">44 big number</dd>
              </div>
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">Total user with score</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">8200</dd>
              </div>
              <div class="flex flex-col-reverse gap-y-4">
                <dt class="text-base leading-7 text-gray-600">Total users required score</dt>
                <dd class="text-5xl font-semibold tracking-tight text-gray-900">6000</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
      <div class="grid grid-cols-12 gap-5">
        <div class="col-span-4">
          <div class="chart">

            <canvas id="social"></canvas>
            <script>
                const social = document.getElementById('social');

                new Chart(social, {
                    type: 'pie',
                    data:
                        {
                            labels: ['Facebook', 'Linkedin', 'Github', 'Google', 'X'],
                            datasets: [
                                {
                                    label: 'Dataset 1',
                                    data: [400, 200, 300, 124, 534],
                                }
                            ]
                        },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    },
                });
            </script>
          </div>
        </div>
        <div class="col-span-4">
          <div class="chart">

            <canvas id="grants"></canvas>
            <script>
                const grants = document.getElementById('grants');

                new Chart(grants, {
                    type: 'pie',
                    data:
                        {
                            labels: ['Facebook', 'Linkedin', 'Github', 'Google', 'X'],
                            datasets: [
                                {
                                    label: 'Dataset 1',
                                    data: [400, 200, 300, 124, 534],
                                }
                            ]
                        },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    },
                });
            </script>
          </div>
        </div>
        <div class="col-span-4">
          <div class="chart">

            <canvas id="myChart"></canvas>
            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'pie',
                    data:
                        {
                            labels: ['Facebook', 'Linkedin', 'Github', 'Google', 'X'],
                            datasets: [
                                {
                                    label: 'Dataset 1',
                                    data: [400, 200, 300, 124, 534],
                                }
                            ]
                        },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    },
                });
            </script>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-32 sm:mt-40 xl:mx-auto xl:max-w-7xl xl:px-8">
      <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12">
          <!-- Display a connect button and the current account -->
          <input type="button"
                 class="rounded-md bg-orange-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600"
                 value="Connect Wallet" onclick="connect();">
          <div id="score">
          </div>
          <div id="account">

          </div>

        </div>
        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Passport Score</h2>
          <ul class="list-none pt-3">
            <li class="font-semibold" id="scoreIndicator"><i class="fa-duotone fa-check text-green-500"></i> Score 20 or above</li>
          </ul>
        </div>
        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Social checklist</h2>
          <ul class="list-none pl-5 pt-3">
            <li><i class="fa-duotone fa-check text-green-500"></i> Facebook</li>
            <li><i class="fa-duotone fa-check text-green-500"></i> Linkedin</li>
            <li><i class="fa-duotone fa-x text-red-500"></i> Github</li>
            <li><i class="fa-duotone fa-check text-green-500"></i> Google</li>
            <li><i class="fa-duotone fa-check text-green-500"></i> X</li>
          </ul>
        </div>
        <div class="col-span-4">
          <h2 class="text-2xl font-bold">Gitcoin Grants</h2>
          <ul class="list-none pt-3">
            <li><i class="fa-duotone fa-x text-red-500"></i> Contributed in GR14</li>
            <li><i class="fa-duotone fa-x text-red-500"></i> Contributed to at least 1 Grant</li>
            <li><i class="fa-duotone fa-x text-red-500"></i> Contributed in at least 1 Round</li>
            <li><i class="fa-duotone fa-x text-red-500"></i> Contributed at least $10</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Image section -->
    <div class="pt-10 xl:mx-auto xl:max-w-7xl xl:px-8">
      <div class="grid grid-cols-3  gap-5">
        <div class="col px-2">
          <img
              src="img/buildspaces4w2_.png"
              alt="" class="aspect-[5/5] w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2">
            <button
                class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              Claim
            </button>
          </div>
        </div>
        <div class="col px-2">
          <img
              src="img/buildspaces4w2_.png"
              alt="" class="aspect-[5/5] w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2">
            <button
                class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              Claim
            </button>
          </div>
        </div>
        <div class="col px-2">
          <img
              src="img/buildspaces4w2_.png"
              alt="" class="aspect-[5/5] w-full object-cover xl:rounded-3xl">
          <div class="text-center pt-2">
            <button
                class="rounded-md bg-gray-400 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              Not elegible
            </button>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <p class="mt-10 text-center text-xs leading-5 text-gray-500">&copy; 2023
        reserved.</p>
    </footer>
  </main>
</div>


</body>
</html>