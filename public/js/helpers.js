function formatRsAmount(amount) {
    if (amount < 10000) {
        return amount;
    } else if (amount < 1000000) {
        return Math.floor(amount / 1000) + 'K'.toString();
    } else if(amount <= 2147483647) {
        return Math.floor(amount / 1000000) + 'M'.toString();
    }
}