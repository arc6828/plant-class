import Pagination from "@/Components/Pagination";
import Translation from "@/Components/Translation";
import VernacularName from "@/Components/VernacularName";
import BootstrapLayout from "@/Layouts/BootstrapLayout";
import { Head } from "@inertiajs/react";
import { useEffect, useState } from "react";
import dayjs from "dayjs";
import 'dayjs/locale/th'

dayjs.locale("th"); // ตั้งค่าให้ใช้ภาษาไทย

const PlantOccurrence = () => {
    const [search, setSearch] = useState("banana");
    const [plants, setPlants] = useState([]);
    const [paginationInfo, setPaginationInfo] = useState({ offset: 0 });
    const [viewMode, setViewMode] = useState("grid"); // Default view is "grid" || "table"

    const handleSearch = async (offset = 0) => {
        const currentYear = new Date().getFullYear();
        const params = new URLSearchParams({
            q: search,
            country: "TH",
            limit: 9,
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

    const ThaiTimeDisplay = (timeString) => {
        // const thaiTime = dayjs().tz("Asia/Bangkok").format("DD MMMM YYYY, HH:mm:ss");
        const year = parseInt(dayjs().year()) + 543;
        const thaiTime = dayjs(timeString).format("DD MMMM") +  " " + year;
      
        return <div>🕒 {thaiTime}</div>;
      };

    useEffect(() => {
        handleSearch(0);
    }, [search]);

    return (
        <BootstrapLayout>
            <Head title="Plant Species Occurrence" />
            <div className="container mt-4">
                <h1 className="mb-4 text-center">
                    ฐานข้อมูลการอุบัติของชนิดพันธุ์พืชในประเทศไทย
                </h1>

                {/* View Mode Selection Dropdown */}
                <div className="my-4 row text-end">
                    <div className="col-6">
                        <div className="input-group mb-3">
                            <input
                                type="text"
                                className="form-control"
                                placeholder="Enter plant name..."
                                value={search}
                                onInput={(e) => setSearch(e.target.value)}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <button
                                className="btn btn-primary"
                                onClick={handleSearch}
                            >
                                Search
                            </button>
                        </div>
                    </div>
                    <label className="col-form-label col-3 fw-bold">
                        View Mode:
                    </label>
                    <div className=" col-3">
                        <select
                            className="form-select"
                            value={viewMode}
                            onChange={(e) => setViewMode(e.target.value)}
                        >
                            <option value="grid">Grid View</option>
                            <option value="table">Table View</option>
                        </select>
                    </div>
                </div>

                {/* Grid View */}
                {viewMode === "grid" && (
                    <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                        {plants.map((plant) => (
                            <div key={plant.id} className="col">
                                <div className="card mb-3 h-100">
                                    <img
                                        src={plant.media[0].identifier}
                                        className="card-img-top"
                                        alt={plant.title}
                                        style={{
                                            height: "200px",
                                            objectFit: "cover",
                                        }}
                                    />
                                    <div className="card-body">
                                        <h5 className="card-title">
                                            {plant.species}
                                        </h5>
                                        <div className="card-text">
                                            <span>{plant.scientificName}</span>
                                        </div>
                                        <div className="card-text">
                                            <VernacularName
                                                species_key={plant.speciesKey}
                                                getVernacularName={
                                                    getVernacularName
                                                }
                                                language="EN"
                                            ></VernacularName>
                                            <span> | </span>
                                            <VernacularName
                                                species_key={plant.speciesKey}
                                                getVernacularName={
                                                    getVernacularName
                                                }
                                                language="TH"
                                            ></VernacularName>
                                        </div>
                                        <div className="card-text">
                                            {ThaiTimeDisplay(plant.eventDate)}
                                        </div>
                                        <div className="card-text">
                                            {plant.stateProvince}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {/* Table View */}
                {viewMode === "table" && (
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
                )}
                <div>
                    <Pagination
                        {...paginationInfo}
                        onPageChange={handlePageChange}
                    />
                </div>
                <div>
                    Open Data API: Powered by{" "}
                    <a href="https://www.gbif.org" target="_blank">
                        GBIF.org
                    </a>
                </div>
            </div>
        </BootstrapLayout>
    );
};

export default PlantOccurrence;
