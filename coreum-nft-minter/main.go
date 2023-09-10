package main

import (
	"crypto/tls"
	"fmt"
	"github.com/cosmos/cosmos-sdk/client/flags"
	"github.com/cosmos/cosmos-sdk/crypto/hd"
	"github.com/cosmos/cosmos-sdk/crypto/keyring"
	sdk "github.com/cosmos/cosmos-sdk/types"
	"github.com/cosmos/cosmos-sdk/types/module"
	"github.com/cosmos/cosmos-sdk/x/auth"
	"golang.org/x/net/context"
	"google.golang.org/grpc"
	"google.golang.org/grpc/credentials"
	"io"
	"net/http"

	"github.com/CoreumFoundation/coreum/v2/pkg/client"
	"github.com/CoreumFoundation/coreum/v2/pkg/config/constant"
	assetnfttypes "github.com/CoreumFoundation/coreum/v2/x/asset/nft/types"
	"github.com/CoreumFoundation/coreum/v2/x/nft"
)

const (
	// Replace it with your own mnemonic, JUST FOR TESTING create it on https://docs.coreum.dev/tools-ecosystem/faucet.html#testnet TODO store safely
	senderMnemonic = ""
	chainID        = constant.ChainIDTest
	addressPrefix  = constant.AddressPrefixTest
	nodeAddress    = "full-node.testnet-1.coreum.dev:9090"
)

func main() {
	http.HandleFunc("/issueclass", issueClass)
	println("Issue NFT 1 class:  http://localhost:8080/issueclass?classSymbol=REGEN1&className=Social%20Wizard&classDescription=Connected%20at%20least%20one%20social%20network%20account&royaltyRate=0.03")
	println("Issue NFT 2 class:  http://localhost:8080/issueclass?classSymbol=REGEN2&className=Stamp%20Collector&classDescription=Connected%20accounts%20to%20score%2020%20or%20above&royaltyRate=0.03")
	println("Issue NFT 3 class:  http://localhost:8080/issueclass?classSymbol=REGEN3&className=Public%20Goods%20Fren&classDescription=Funded%20public%20goods%20in%20Gitcoin%20Grants&royaltyRate=0.03")

	http.HandleFunc("/mintnft", mintNFT)
	println("Mint NFT 1:  http://localhost:8080/mintnft?classSymbol=REGEN1&nftID=NFT0001&recipientAddress=testcore145jqrvpv873w9nxcn6vr4es8ygfeyw2u44zpk5")
	println("Mint NFT 2:  http://localhost:8080/mintnft?classSymbol=REGEN2&nftID=NFT0001&recipientAddress=testcore145jqrvpv873w9nxcn6vr4es8ygfeyw2u44zpk5")
	println("Mint NFT 3:  http://localhost:8080/mintnft?classSymbol=REGEN3&nftID=NFT0001&recipientAddress=testcore145jqrvpv873w9nxcn6vr4es8ygfeyw2u44zpk5")
	err := http.ListenAndServe(":8080", nil)
	if err != nil {
		fmt.Println("Error:", err)
	}
}

func issueClass(res http.ResponseWriter, req *http.Request) {
	// TODO try except
	io.WriteString(res, "classSymbol: "+req.FormValue("classSymbol"))
	io.WriteString(res, "\nclassName: "+req.FormValue("className"))
	io.WriteString(res, "\nclassDescription: "+req.FormValue("classDescription"))
	io.WriteString(res, "\nroyaltyRate: "+req.FormValue("royaltyRate"))

	// Configure Cosmos SDK
	config := sdk.GetConfig()
	config.SetBech32PrefixForAccount(addressPrefix, addressPrefix+"pub")
	config.SetCoinType(constant.CoinType)
	//config.Seal()

	// List required modules.
	// If you need types from any other module import them and add here.
	modules := module.NewBasicManager(
		auth.AppModuleBasic{},
	)

	// Configure client context and tx factory
	grpcClient, err := grpc.Dial(nodeAddress, grpc.WithTransportCredentials(credentials.NewTLS(&tls.Config{})))
	if err != nil {
		panic(err)
	}

	clientCtx := client.NewContext(client.DefaultContextConfig(), modules).
		WithChainID(string(chainID)).
		WithGRPCClient(grpcClient).
		WithKeyring(keyring.NewInMemory()).
		WithBroadcastMode(flags.BroadcastBlock)

	txFactory := client.Factory{}.
		WithKeybase(clientCtx.Keyring()).
		WithChainID(clientCtx.ChainID()).
		WithTxConfig(clientCtx.TxConfig()).
		WithSimulateAndExecute(true)

	// Generate private key and add it to the keystore
	senderInfo, err := clientCtx.Keyring().NewAccount(
		"key-name",
		senderMnemonic,
		"",
		sdk.GetConfig().GetFullBIP44Path(),
		hd.Secp256k1,
	)
	if err != nil {
		panic(err)
	}

	// Broadcast transaction issuing new nft class
	classSymbol := req.FormValue("classSymbol")
	className := req.FormValue("className")
	classDescription := req.FormValue("classDescription")
	royaltyRateInt := req.FormValue("royaltyRate")

	royaltyRate := sdk.MustNewDecFromStr(royaltyRateInt)
	msgIssueClass := &assetnfttypes.MsgIssueClass{
		Issuer:      senderInfo.GetAddress().String(),
		Symbol:      classSymbol,
		Name:        className,
		Description: classDescription,
		Features:    []assetnfttypes.ClassFeature{assetnfttypes.ClassFeature_burning, assetnfttypes.ClassFeature_freezing, assetnfttypes.ClassFeature_disable_sending},
		RoyaltyRate: royaltyRate,
	}

	ctx := context.Background()
	_, err = client.BroadcastTx(
		ctx,
		clientCtx.WithFromAddress(senderInfo.GetAddress()),
		txFactory,
		msgIssueClass,
	)
	if err != nil {
		panic(err)
	}
}

func mintNFT(res http.ResponseWriter, req *http.Request) {
	// TODO try except
	io.WriteString(res, "classSymbol: "+req.FormValue("classSymbol"))
	io.WriteString(res, "\nnftID: "+req.FormValue("nftID"))
	io.WriteString(res, "\nrecipientAddress: "+req.FormValue("recipientAddress"))

	// Configure Cosmos SDK
	config := sdk.GetConfig()
	config.SetBech32PrefixForAccount(addressPrefix, addressPrefix+"pub")
	config.SetCoinType(constant.CoinType)
	//config.Seal()

	// List required modules.
	// If you need types from any other module import them and add here.
	modules := module.NewBasicManager(
		auth.AppModuleBasic{},
	)

	// Configure client context and tx factory
	grpcClient, err := grpc.Dial(nodeAddress, grpc.WithTransportCredentials(credentials.NewTLS(&tls.Config{})))
	if err != nil {
		panic(err)
	}

	clientCtx := client.NewContext(client.DefaultContextConfig(), modules).
		WithChainID(string(chainID)).
		WithGRPCClient(grpcClient).
		WithKeyring(keyring.NewInMemory()).
		WithBroadcastMode(flags.BroadcastBlock)

	txFactory := client.Factory{}.
		WithKeybase(clientCtx.Keyring()).
		WithChainID(clientCtx.ChainID()).
		WithTxConfig(clientCtx.TxConfig()).
		WithSimulateAndExecute(true)

	// Generate private key and add it to the keystore
	senderInfo, err := clientCtx.Keyring().NewAccount(
		"key-name",
		senderMnemonic,
		"",
		sdk.GetConfig().GetFullBIP44Path(),
		hd.Secp256k1,
	)
	if err != nil {
		panic(err)
	}

	// Broadcast transaction issuing new nft class
	classSymbol := req.FormValue("classSymbol")
	nftID := req.FormValue("nftID")

	ctx := context.Background()

	// Broadcast transaction minting new nft
	classID := assetnfttypes.BuildClassID(classSymbol, senderInfo.GetAddress())
	msgMint := &assetnfttypes.MsgMint{
		Sender:  senderInfo.GetAddress().String(),
		ClassID: classID,
		ID:      nftID,
	}

	_, err = client.BroadcastTx(
		ctx,
		clientCtx.WithFromAddress(senderInfo.GetAddress()),
		txFactory,
		msgMint,
	)
	if err != nil {
		panic(err)
	}

	// Query the owner of the NFT
	nftClient := nft.NewQueryClient(clientCtx)
	resp, err := nftClient.Owner(ctx, &nft.QueryOwnerRequest{
		ClassId: classID,
		Id:      nftID,
	})
	if err != nil {
		panic(err)
	}
	fmt.Printf("Owner: %s\n", resp.Owner)

	// Send the NFT to someone
	//recipientInfo, _, err := clientCtx.Keyring().NewMnemonic(
	//	"recipient",
	//	keyring.English,
	//	sdk.GetConfig().GetFullBIP44Path(),
	//	"",
	//	hd.Secp256k1,
	//)
	//if err != nil {
	//	panic(err)
	//}

	recipientAddress := req.FormValue("recipientAddress")
	msgSend := &nft.MsgSend{
		Sender:   senderInfo.GetAddress().String(),
		Receiver: recipientAddress, // "testcore145jqrvpv873w9nxcn6vr4es8ygfeyw2u44zpk5", //recipientInfo.GetAddress().String(),
		Id:       nftID,
		ClassId:  classID,
	}

	_, err = client.BroadcastTx(
		ctx,
		clientCtx.WithFromAddress(senderInfo.GetAddress()),
		txFactory,
		msgSend,
	)
	if err != nil {
		panic(err)
	}

	// Query the owner of the NFT again
	resp, err = nftClient.Owner(ctx, &nft.QueryOwnerRequest{
		ClassId: classID,
		Id:      nftID,
	})
	if err != nil {
		panic(err)
	}

	fmt.Printf("New owner: %s\n", resp.Owner)

	// Freeze balance portion of the recipient's balance
	msgFreeze := &assetnfttypes.MsgFreeze{
		Sender:  senderInfo.GetAddress().String(),
		ClassID: classID,
		ID:      nftID,
	}

	_, err = client.BroadcastTx(
		ctx,
		clientCtx.WithFromAddress(senderInfo.GetAddress()),
		txFactory,
		msgFreeze,
	)
	if err != nil {
		panic(err)
	}
}
