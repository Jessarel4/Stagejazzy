import { useState, useEffect } from "react";
import { DataGrid, GridColDef } from "@mui/x-data-grid";
import axios from "axios";
import "./dataTablesubstance.scss";

const DataTableTypeSubstance = () => {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/type-substances");
        console.log("Données de l'API TypeSubstance:", response.data);
        const typeSubstances = response.data.map((typeSubstance: any) => ({
          id: typeSubstance.id_type_substance,
          nom: typeSubstance.nom_type_substance,
          sigle: typeSubstance.sigle_type_substance,
          limiteProduction: typeSubstance.limite_production_type_substance,
          uniteLimite: typeSubstance.unite_limite_type_substance,
        }));
        setRows(typeSubstances);
        console.log("Rows après la mise à jour:", typeSubstances);
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchData();
  }, []);

  const columns: GridColDef[] = [
    { field: 'id', headerName: 'ID', width: 90 },
    { field: 'nom', headerName: 'Nom', width: 150 },
    { field: 'sigle', headerName: 'Sigle', width: 150 },
    { field: 'limiteProduction', headerName: 'Limite de Production', width: 200 },
    { field: 'uniteLimite', headerName: 'Unité Limite', width: 150 },
  ];

  return (
    <div className="dataTable">
      <DataGrid
        rows={rows}
        columns={columns}
        initialState={{
          pagination: {
            paginationModel: {
              pageSize: 10,
            },
          },
        }}
        pageSizeOptions={[10]}
        checkboxSelection
        disableRowSelectionOnClick
      />
    </div>
  );
};

export default DataTableTypeSubstance;
