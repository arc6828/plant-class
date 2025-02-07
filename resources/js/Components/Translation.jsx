import DictionaryService from "@/Services/DictionaryService";
import { usePage } from "@inertiajs/react";
import { useState, useEffect } from "react";

const Translation = ({ text }) => {
    const [transformedText, setTransformedText] = useState("");
    const { dictionary } = usePage().props

    const getTranslation = async () => {
        if (!text) return;

        // hit dictionary
        if (text in dictionary) {
            console.log("HIT Dicationary");
            setTransformedText(dictionary[text]);   
            return;
        }

        // hit google
        console.log("HIT Google", text);
        const results = await DictionaryService.translate(text);
        results && setTransformedText(results.output);        
    };

    useEffect(() => {
        getTranslation();
        // console.log(dictionary);
    }, [text]);

    return (
        <span>            
            { transformedText || text }
        </span>
    );
};

export default Translation;