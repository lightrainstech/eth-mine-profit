# Ethereum Mining Profit Calculator

### Network hashrate
Estimated the network hashrate in GH using the following equation.

`netHashGH = (difficulty / blockTime) / 1e9;`

Where difficulty is the current difficulty to mine a block and blockTime is the networks current block time. PHP port of [badmofo/ethereum-mining-calculator](https://github.com/badmofo/ethereum-mining-calculator)
