import Pagination from "@/Components/Pagination";
import Translation from "@/Components/Translation";
import VernacularName from "@/Components/VernacularName";
import BootstrapLayout from "@/Layouts/BootstrapLayout";
import { Head } from "@inertiajs/react";
import { useEffect, useState } from "react";

const PlantOccurrence = () => {
    const [search, setSearch] = useState("banana");
    const [plants, setPlants] = useState([]);
    const [paginationInfo, setPaginationInfo] = useState({ offset : 0 });

    const handleSearch = async (offset=0) => {
        const currentYear = new Date().getFullYear();
        const params = new URLSearchParams({
            q: search,
            country: "TH",
            limit: 10,
            kingdomKey: 6,
            year: `2020,${currentYear}`,
            offset: offset,
        });
        const url = `https://api.gbif.org/v1/occurrence/search?${params.toString()}`;
        // `http://localhost:8000/api/plants?search=${search}`
        // `https://api.gbif.org/v1/occurrence/search?country=TH&kingdomKey=6&limit=10`
        console.log(url);
        const response = await fetch(url);
        const data = await response.json();
        // results
        setPlants(data.results);
        const { results, ...pageInfo } = data;
        console.log(pageInfo);
        setPaginationInfo(pageInfo);
    };

    const getVernacularName = async (species_key) => {
        if (!species_key) return;

        // console.log("name");
        try {
            const response = await fetch(
                // `https://api.gbif.org/v1/species/2760990/vernacularNames`
                `https://api.gbif.org/v1/species/${species_key}/vernacularNames`
            );
            const data = await response.json();
            if (data.results.length > 0) {
                let filtered_data = data.results.filter(
                    (item) => item.language == "eng"
                );
                filtered_data =
                    filtered_data.length > 0 ? filtered_data[0] : data[0];
                return filtered_data.vernacularName;
            } else {
                return "-";
            }
        } catch (error) {
            console.error("Error fetching transformed text:", error);
        }
    };

    const handlePageChange = (newOffset) => {
        setPaginationInfo((prev) => ({
            ...prev,
            offset: newOffset,
            endOfRecords: newOffset + prev.limit >= prev.count,
        }));
        handleSearch(newOffset);
    };

    useEffect(() => {
        handleSearch(0);
    }, [search]);

    return (
        <BootstrapLayout>
            <Head title="Plant Species Occurrence" />
            <div className="container mt-4">
                <h2 className="mb-3">Plant Species Occurrence Search</h2>

                <div className="input-group mb-3">
                    <input
                        type="text"
                        className="form-control"
                        placeholder="Enter plant name..."
                        value={search}
                        onInput={(e) => setSearch(e.target.value)}
                        onChange={(e) => setSearch(e.target.value)}
                    />
                    <button className="btn btn-primary" onClick={handleSearch}>
                        Search
                    </button>
                </div>

                <table className="table table-striped table-bordered">
                    <thead className="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Province</th>
                            <th>Species</th>
                            <th>Family</th>
                            <th>Genus</th>
                            <th>Common Name</th>
                            <th>TH</th>
                        </tr>
                    </thead>
                    <tbody>
                        {plants.length > 0 ? (
                            plants.map((plant) => (
                                <tr key={plant.key}>
                                    <td>{plant.eventDate}</td>
                                    <td>{plant.stateProvince}</td>
                                    <td>{plant.species} </td>
                                    <td>{plant.family}</td>
                                    <td>{plant.genus}</td>
                                    <td>
                                        <VernacularName
                                            species_key={plant.speciesKey}
                                            getVernacularName={
                                                getVernacularName
                                            }
                                            language="EN"
                                        ></VernacularName>
                                    </td>
                                    <td>
                                        <VernacularName
                                            species_key={plant.speciesKey}
                                            getVernacularName={
                                                getVernacularName
                                            }
                                            language="TH"
                                        ></VernacularName>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="4" className="text-center">
                                    No results found
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>

                <div>
                    <Pagination
                        {...paginationInfo}
                        onPageChange={handlePageChange}
                    />
                </div>
            </div>
        </BootstrapLayout>
    );
};

export default PlantOccurrence;
