import VernacularName from "@/Components/VernacularName";
import BootstrapLayout from "@/Layouts/BootstrapLayout";
import { Head } from "@inertiajs/react";
import { useEffect, useState } from "react";

const PlantOccurrence = () => {
    const [search, setSearch] = useState("banana");
    const [plants, setPlants] = useState([]);

    const handleSearch = async () => {
        const params = new URLSearchParams({
            q: search,
            country: "TH",
            limit: 10,
            kingdomKey: 6,
            year: 2024,
        });
        const response = await fetch(
            // `http://localhost:8000/api/plants?search=${search}`
            // `https://api.gbif.org/v1/occurrence/search?country=TH&kingdomKey=6&limit=10`
            `https://api.gbif.org/v1/occurrence/search?${params.toString()}`
        );
        const data = await response.json();
        setPlants(data.results);
    };

    useEffect(() => {
        handleSearch();
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
                                    <td>{plant.species}</td>
                                    <td>{plant.family}</td>
                                    <td>{plant.genus}</td>
                                    <td>
                                    <VernacularName species_key={plant.speciesKey}></VernacularName>
                                    </td>
                                    <td>

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
            </div>
        </BootstrapLayout>
    );
};

export default PlantOccurrence;