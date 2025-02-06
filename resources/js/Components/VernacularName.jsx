import { useState, useEffect } from "react";

const VernacularName = ({ species_key }) => {
    const [transformedText, setTransformedText] = useState("");

    const getVernacularName = async () => {
        if (!species_key) return;

        // console.log("name");
        try {
            const response = await fetch(
                // `https://api.gbif.org/v1/species/2760990/vernacularNames`
                `https://api.gbif.org/v1/species/${species_key}/vernacularNames`
            );
            const data = await response.json();
            let filtered_data = data.results.filter((item)=>(item.language == "eng"));
            filtered_data = filtered_data.length > 0 ? filtered_data[0] : data[0];
            setTransformedText(filtered_data.vernacularName);
        } catch (error) {
            console.error("Error fetching transformed text:", error);
            setTransformedText("...");
        }
    };

    useEffect(() => {
        getVernacularName();
    }, [species_key]);

    return (
        <span>
            
            { transformedText || "Loading..."}
        </span>
    );
};

export default VernacularName;