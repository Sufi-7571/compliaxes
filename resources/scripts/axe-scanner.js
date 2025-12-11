const puppeteer = require('puppeteer');
const fs = require('fs');

const url = process.argv[2];
const outputFile = process.argv[3];

if (!url || !outputFile) {
    console.error('Usage: node axe-scanner.js <url> <output-file>');
    process.exit(1);
}

(async () => {
    let browser;
    try {
        browser = await puppeteer.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu'
            ]
        });

        const page = await browser.newPage();

        console.log('Navigating to:', url);
        await page.goto(url, {
            waitUntil: 'networkidle2',
            timeout: 60000
        });

        console.log('Injecting axe-core...');
        await page.addScriptTag({
            path: './node_modules/axe-core/axe.min.js'
        });

        console.log('Running axe analysis...');
        const results = await page.evaluate(() => {
            return new Promise((resolve) => {
                axe.run((err, results) => {
                    if (err) {
                        resolve({ error: err.message });
                    } else {
                        resolve(results);
                    }
                });
            });
        });

        console.log('Writing results...');
        fs.writeFileSync(outputFile, JSON.stringify(results, null, 2));
        console.log('Scan completed successfully');

    } catch (error) {
        console.error('Error during scan:', error.message);
        fs.writeFileSync(outputFile, JSON.stringify({
            error: error.message,
            violations: []
        }, null, 2));
    } finally {
        if (browser) {
            await browser.close();
        }
    }
})();