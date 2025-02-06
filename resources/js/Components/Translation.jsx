import { useState, useEffect } from "react";

const Translation = ({ text }) => {
    const [transformedText, setTransformedText] = useState("");

    const getTranslation = async () => {
        if (!text) return;

        // console.log("name");
        try {
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ input : text })
            };
            const url = `https://ml.ckartisan.com/nlp/translate`;
            const response = await fetch( url , options );
            const data = await response.json();
            
            setTransformedText(data.output);
        } catch (error) {
            console.error("Error fetching transformed text:", error);
            // setTransformedText("...");
        }
    };

    useEffect(() => {
        getTranslation();
    }, [text]);

    return (
        <span>            
            { transformedText || "Loading..."}
        </span>
    );
};

export default Translation;