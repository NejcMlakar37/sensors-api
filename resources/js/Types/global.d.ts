export {};

declare global {
    type Company = {
        id: number,
        name: string,
        address: string,
        city: string,
        postcode: string,
        country: string,
        email: string,
    }

    type AuthenticatedUser = {
        id: number,
        username: string,
        email: string,
        company: Company,
    }

    type Measurement = {
        id: number,
        sensor: Sensor,
        temperature: number,
        humidity: number,
        timestamp: string
    }

    export type PageProps<
        T extends Record<string, unknown> = Record<string, unknown>
    > = T & {
        auth: {
            user: AuthenticatedUser;
        };
        sensors: Sensor[],
        flash: {
            success: boolean | null;
            message: string | null;
        };
    };

    type Sensor = {
        id: number,
        name: string,
        location: string,
        position: number,
        battery: string | number,
        active_temp_alert: boolean,
        active_humid_alert: boolean,
    }

    type SensorWithLatest = Sensor & {
        latest_measurement: Measurement
    }

    type Series = {
        name: string;
        data: any[];
    }

    type Incident = {
        id: number,
        sensor: Sensor,
        type: string,
        min: number,
        max: number,
        value: number,
        created_at: string,
    }

    type SensorLimit = {
        id: number,
        sensor: Sensor | undefined,
        min_temp: number,
        max_temp: number,
        min_humidity: number,
        max_humidity: number,
    }

    type Recipient = {
        id: number,
        sensor: Sensor | undefined,
        email: string,
    }

    type UpdateMutation<T> = {
        isLoading: boolean,
        mutate: (id: number, object: T | any, onFinish?: () => void) => number
        identifier: number,
    }

    type CreateMutation<T> = {
        isLoading: boolean,
        mutate: (object: T | any, onFinish?: () => void) => void
    }

    type DeleteMutation<T> = {
        isLoading: boolean,
        mutate: (id: number, confirmMsg?: string, onFinish?: () => void) => void
        identifier: number,
    }
}