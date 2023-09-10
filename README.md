# Regenscore: Get NFT's (Permissionless II hackathon contribution) 
Regenscore is a platform where regens can unlock airdrops for creating value. We do this by aggregating open data, measuring positive actions on a network, platform, or protocol, and create incentives for people who level up and unlock crypto rewards.

We believe crypto should be a win win game where all participants can grow and thrive. We are inspired by projects like Gitcoin and authors like Kevin Owocki, and aim to help the ecosystem grow in alignment with the values of regen cryptoeconomics. 

Rewards are programmable. Incentives can be financial or social. The goal is to encourage regenerative actions that incentivize people to contribute to the ecosystem in meaningful ways, earning rewards along the way.

The Regenscore alpha product uses Gitcoin Passport onchain data to calculate a person's regen score and unlocks rewards with a variety of criteria requirements. Signing in with your crypto wallet calculates your regen score and shows you which airdrops you are eligible to claim, and the actions needed to unlock the rewards for which you are not yet eligible.

Future versions of Regenscore will make use of different reward types including soulbound tokens, and fungible tokens.


This application is made in the 24-hour [Permissionless II hackathon](https://blockworks.co/event/permissionless-2023-hackathon/home) and submitted to the following challenges:

-
-

  
# Gitcoin Passport dashboard data
For the metrics on the homepage, we used the [Gitcoin Passport API](https://docs.passport.gitcoin.co/building-with-passport/api-reference#available-endpoints) in order to scrape score and stamp data from all addresses with an [Gitcoin Passport on-chain attestation](https://optimism.easscan.org/address/0x843829986e895facd330486a61Ebee9E1f1adB1a). Please note that this has a bias to more advanced used users (as they would benefit from on-chain stamps).

# 1) Setting up the web-app


# 2) Setting up Coreum
1) Place a testnet mnemonic with funds in `main.go` on line 26, and run the Go application.

2) Browse the following pages once to issue the NFT smart token classes:
- [Issue NFT 1 class](http://localhost:8080/issueclass?classSymbol=REGEN1&className=Social%20Wizard&classDescription=Connected%20at%20least%20one%20social%20network%20account&royaltyRate=0.03)
- [Issue NFT 2 class](http://localhost:8080/issueclass?classSymbol=REGEN2&className=Stamp%20Collector&classDescription=Connected%20accounts%20to%20score%2020%20or%20above&royaltyRate=0.03)
- [Issue NFT 3 class](http://localhost:8080/issueclass?classSymbol=REGEN3&className=Public%20Goods%20Fren&classDescription=Funded%20public%20goods%20in%20Gitcoin%20Grants&royaltyRate=0.03)

The application will mint the NFT smart tokens through an API: `http://localhost:8080/mintnft?classSymbol=REGEN1&nftID=NFT0001&recipientAddress=TESTNET_ADDRESS`.
Please note that `NFT0001` should be replaced with a counter and `TESTNET_ADDRESS` with the recipient address.
These smart tokens use the [token features](https://docs.coreum.dev/modules/assetnft.html#token-features) burning, freezing and disable sending.

Example of these issuances and mints: [address testcore18zduv6tgq7z0l0g5q672sxx24av9e978d2aucc](https://explorer.testnet-1.coreum.dev/coreum/accounts/testcore18zduv6tgq7z0l0g5q672sxx24av9e978d2aucc)
