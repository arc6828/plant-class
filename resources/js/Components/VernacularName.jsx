import { useState, useEffect } from "react";
import Translation from "./Translation";
import { usePage } from "@inertiajs/react";

const VernacularName = ({ species_key, language }) => {
    const { dictionary } = usePage().props
    const [text, setText] = useState("");

    const getVernacularName = async (species_key) => {
        if (!species_key) return;

        // console.log("name");
        // fast answer with cache
        // hit dictionary
        if (species_key in dictionary) {
            console.log("HIT Dicationary, VernacularName");
            // setText(dictionary[species_key]);   
            // return dictionary["SpeciesKey-"+species_key];
        }

        // `https://api.gbif.org/v1/species/2760990/vernacularNames`
        // https://api.gbif.org/v1/species/5332330/vernacularNames
        const url = `https://api.gbif.org/v1/species/${species_key}/vernacularNames`;
        try {
            const response = await fetch(url);
            const data = await response.json();
            if (data.results.length > 0) {
                let filtered_data = data.results.filter(
                    (item) => item.language == "eng"
                );
                filtered_data =
                    filtered_data.length > 0 ? filtered_data[0] : data.results[0];
                return filtered_data.vernacularName;
            } else {
                return "-";
            }
        } catch (error) {
            console.error("Error fetching transformed text:", error, url);
        }
    };

    const onLoad = async () => {
        let name = await getVernacularName(species_key);
        setText(name);
    };

    useEffect(() => {
        onLoad();
    }, []);
    if (language == "EN") return <span>{text || "Loading..."}</span>;
    else if (language == "TH" && text)
        return <Translation text={text} tags={"VernacularName"} />;
    else return <span>{"Loading..."}</span>;
};

export default VernacularName;
