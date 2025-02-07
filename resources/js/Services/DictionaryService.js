const DictionaryService = {
    async translate(text) {
        if (!text) return;

        try {
            // console.log("google hit");
            const options = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ input: text }),
            };
            const url = `https://ml.ckartisan.com/nlp/translate`;
            const response = await fetch(url, options);
            const data = await response.json();

            // update dictionary
            await this.addDictionry(data);

            return data; // { input , output }
        } catch (error) {
            console.error("Error fetching transformed text:", error);
            return;
        }
    },
    async addDictionry(data) {        
        try {
            const options = {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json", // outgoing
                    'Accept': 'application/json',       // imcoming
                },
                body: JSON.stringify(data),
            };
            const url = `/api/dictionary`;
            const response = await fetch(url, options);
            const result = await response.json();

            return result; // { input , output }
        } catch (error) {
            console.error("Error fetching transformed text:", error);
            return;
        }
    },
};

export default DictionaryService;
