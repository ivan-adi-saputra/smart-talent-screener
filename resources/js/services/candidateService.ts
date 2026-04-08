import axios from "axios";
import { AnalyzeCVResponse } from "../types/candidate";

export const candidateService = {
    analyzeCV: async (file: File): Promise<AnalyzeCVResponse> => {
        const formData = new FormData();
        formData.append("cv_file", file);

        const response = await axios.post<AnalyzeCVResponse>(
            "/api/analyze-cv",
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            },
        );

        return response.data;
    },
};
